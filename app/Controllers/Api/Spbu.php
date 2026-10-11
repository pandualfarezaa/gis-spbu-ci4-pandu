<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

/**
 * REST API SPBU (format JSON)
 *
 * GET    /api/spbu            -> daftar SPBU (filter: status, id_jenis, id_kabupaten, id_kecamatan, id_wilayah, q, limit, page)
 * GET    /api/spbu/{id}       -> detail satu SPBU
 * GET    /api/spbu/geojson    -> semua SPBU dalam format GeoJSON (titik)
 * POST   /api/spbu            -> tambah SPBU
 * PUT    /api/spbu/{id}       -> ubah SPBU (boleh sebagian field)
 * DELETE /api/spbu/{id}       -> hapus SPBU
 */
class Spbu extends ResourceController
{
    protected $format = 'json';

    /** Kolom tbl_spbu yang boleh diisi lewat API */
    private array $allowed = [
        'nama_spbu', 'id_jenis', 'status', 'rest_area', 'lokasi', 'foto',
        'alamat', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'id_wilayah',
    ];

    /* ------------------------------------------------------------------ */
    /*  READ                                                               */
    /* ------------------------------------------------------------------ */

    public function index()
    {
        $q   = $this->baseQuery();
        $req = $this->request;

        if ($status = $req->getGet('status')) {
            $q->where('s.status', $status);
        }
        foreach (['id_jenis', 'id_kabupaten', 'id_kecamatan', 'id_wilayah'] as $f) {
            $v = $req->getGet($f);
            if ($v !== null && $v !== '') {
                $q->where('s.' . $f, (int) $v);
            }
        }
        if ($kw = $req->getGet('q')) {
            $q->like('s.nama_spbu', $kw, 'both', null, true); // pencarian tidak peduli huruf besar/kecil (ILIKE)
        }

        $total = $q->countAllResults(false);

        $q->orderBy('s.id_spbu', 'ASC');

        // Opsional: paginasi. Tanpa ?limit= semua data dikirim (nyaman untuk Power BI)
        $limit = (int) ($req->getGet('limit') ?? 0);
        if ($limit > 0) {
            $limit = min($limit, 1000);
            $page  = max(1, (int) ($req->getGet('page') ?? 1));
            $q->limit($limit, ($page - 1) * $limit);
        }

        $rows = array_map([$this, 'formatRow'], $q->get()->getResultArray());

        return $this->respond([
            'status'  => 200,
            'message' => 'OK',
            'total'   => $total,
            'data'    => $rows,
        ]);
    }

    public function show($id = null)
    {
        $row = $this->findOne((int) $id);
        if (! $row) {
            return $this->failNotFound("SPBU dengan id {$id} tidak ditemukan");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'OK',
            'data'    => $row,
        ]);
    }

    public function geojson()
    {
        $rows     = $this->baseQuery()->orderBy('s.id_spbu', 'ASC')->get()->getResultArray();
        $features = [];

        foreach ($rows as $r) {
            $r = $this->formatRow($r);
            if ($r['latitude'] === null) {
                continue; // lewati data yang koordinatnya tidak valid
            }
            $coords = [$r['longitude'], $r['latitude']]; // GeoJSON: [lng, lat]
            unset($r['latitude'], $r['longitude'], $r['lokasi']);

            $features[] = [
                'type'       => 'Feature',
                'geometry'   => ['type' => 'Point', 'coordinates' => $coords],
                'properties' => $r,
            ];
        }

        return $this->respond([
            'type'     => 'FeatureCollection',
            'features' => $features,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  CREATE / UPDATE / DELETE                                           */
    /* ------------------------------------------------------------------ */

    public function create()
    {
        $data = $this->cleanInput($this->input());

        if (! $this->validateData($data, $this->rules())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        if (! $this->validLokasi($data['lokasi'])) {
            return $this->failValidationErrors(['lokasi' => 'Format lokasi harus "latitude, longitude", contoh: -7.2652, 109.0125']);
        }

        $db = \Config\Database::connect();
        $db->table('tbl_spbu')->insert($data);
        $id = $db->insertID();

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'SPBU berhasil ditambahkan',
            'data'    => $this->findOne((int) $id),
        ]);
    }

    public function update($id = null)
    {
        $id = (int) $id;
        if (! $this->findOne($id)) {
            return $this->failNotFound("SPBU dengan id {$id} tidak ditemukan");
        }

        $data = $this->cleanInput($this->input());
        if (empty($data)) {
            return $this->fail('Tidak ada data yang dikirim untuk diubah', 400);
        }

        // Hanya validasi field yang dikirim (update boleh sebagian)
        $rules = array_intersect_key($this->rules(), $data);
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        if (isset($data['lokasi']) && ! $this->validLokasi($data['lokasi'])) {
            return $this->failValidationErrors(['lokasi' => 'Format lokasi harus "latitude, longitude", contoh: -7.2652, 109.0125']);
        }

        \Config\Database::connect()->table('tbl_spbu')->where('id_spbu', $id)->update($data);

        return $this->respond([
            'status'  => 200,
            'message' => 'SPBU berhasil diubah',
            'data'    => $this->findOne($id),
        ]);
    }

    public function delete($id = null)
    {
        $id = (int) $id;
        if (! $this->findOne($id)) {
            return $this->failNotFound("SPBU dengan id {$id} tidak ditemukan");
        }

        \Config\Database::connect()->table('tbl_spbu')->where('id_spbu', $id)->delete();

        return $this->respond([
            'status'  => 200,
            'message' => "SPBU dengan id {$id} berhasil dihapus",
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Helper                                                             */
    /* ------------------------------------------------------------------ */

    /** Query dasar: tbl_spbu + nama jenis, provinsi, kabupaten, kecamatan, wilayah */
    private function baseQuery()
    {
        return \Config\Database::connect()->table('tbl_spbu s')
            ->select('s.id_spbu, s.nama_spbu, s.status, s.rest_area, s.lokasi, s.foto, s.alamat, '
                . 's.id_jenis, j.jenis, s.id_provinsi, p.nama AS provinsi, '
                . 's.id_kabupaten, k.nama AS kabupaten, s.id_kecamatan, c.nama AS kecamatan, '
                . 's.id_wilayah, w.nama_wilayah')
            ->join('tbl_jenis j', 'j.id_jenis = s.id_jenis', 'left')
            ->join('tbl_provinsi p', 'p.id = s.id_provinsi', 'left')
            ->join('tbl_kabupaten k', 'k.id = s.id_kabupaten', 'left')
            ->join('tbl_kecamatan c', 'c.id = s.id_kecamatan', 'left')
            ->join('tbl_wilayah w', 'w.id_wilayah = s.id_wilayah', 'left');
    }

    private function findOne(int $id): ?array
    {
        $row = $this->baseQuery()->where('s.id_spbu', $id)->get()->getRowArray();

        return $row ? $this->formatRow($row) : null;
    }

    /** Ubah hasil query jadi JSON yang rapi (angka sebagai angka, lat/lng terpisah, URL foto) */
    private function formatRow(array $row): array
    {
        foreach (['id_spbu', 'id_jenis', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'id_wilayah'] as $k) {
            $row[$k] = ($row[$k] ?? null) !== null ? (int) $row[$k] : null;
        }

        [$lat, $lng]      = $this->parseLokasi($row['lokasi'] ?? '');
        $row['latitude']  = $lat;
        $row['longitude'] = $lng;
        $row['foto_url']  = ! empty($row['foto']) ? base_url('foto/' . $row['foto']) : null;

        return $row;
    }

    private function parseLokasi(?string $lokasi): array
    {
        $parts = array_map('trim', explode(',', (string) $lokasi));
        if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
            return [(float) $parts[0], (float) $parts[1]];
        }

        return [null, null];
    }

    private function validLokasi(string $lokasi): bool
    {
        return (bool) preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', trim($lokasi));
    }

    /** Baca body request: mendukung JSON, form-data, dan x-www-form-urlencoded (termasuk PUT) */
    private function input(): array
    {
        if (str_contains($this->request->getHeaderLine('Content-Type'), 'application/json')) {
            $json = json_decode((string) $this->request->getBody(), true);

            return is_array($json) ? $json : [];
        }

        $data = $this->request->getPost();
        if (empty($data)) {
            $data = $this->request->getRawInput();
        }

        return is_array($data) ? $data : [];
    }

    /** Ambil hanya kolom yang diizinkan, rapikan spasi, string kosong jadi NULL */
    private function cleanInput(array $input): array
    {
        $data = array_intersect_key($input, array_flip($this->allowed));

        foreach ($data as $k => $v) {
            if (is_string($v)) {
                $v = trim($v);
            }
            $data[$k] = ($v === '') ? null : $v;
        }

        return $data;
    }

    private function rules(): array
    {
        return [
            'nama_spbu'    => 'required|max_length[50]',
            'id_jenis'     => 'required|integer|is_not_unique[tbl_jenis.id_jenis]',
            'status'       => 'required|in_list[Aktif,Tidak Aktif]',
            'rest_area'    => 'permit_empty|max_length[50]',
            'lokasi'       => 'required|max_length[150]',
            'foto'         => 'permit_empty|max_length[255]',
            'alamat'       => 'permit_empty',
            'id_provinsi'  => 'permit_empty|integer|is_not_unique[tbl_provinsi.id]',
            'id_kabupaten' => 'permit_empty|integer|is_not_unique[tbl_kabupaten.id]',
            'id_kecamatan' => 'permit_empty|integer|is_not_unique[tbl_kecamatan.id]',
            'id_wilayah'   => 'permit_empty|integer|is_not_unique[tbl_wilayah.id_wilayah]',
        ];
    }
}
