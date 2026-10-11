<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

/**
 * API data referensi (hanya baca / GET)
 *
 * GET /api/jenis
 * GET /api/provinsi
 * GET /api/kabupaten            (opsional ?id_provinsi=33)
 * GET /api/kecamatan            (opsional ?id_kabupaten=3301)
 * GET /api/wilayah              (daftar wilayah tanpa GeoJSON, ringan)
 * GET /api/wilayah/{id}         (detail wilayah + GeoJSON)
 */
class Referensi extends ResourceController
{
    protected $format = 'json';

    public function jenis()
    {
        $rows = \Config\Database::connect()->table('tbl_jenis')
            ->select('id_jenis, jenis, marker')
            ->orderBy('id_jenis', 'ASC')->get()->getResultArray();

        return $this->output($this->castInts($rows, ['id_jenis']));
    }

    public function provinsi()
    {
        $rows = \Config\Database::connect()->table('tbl_provinsi')
            ->select('id, nama')
            ->orderBy('id', 'ASC')->get()->getResultArray();

        return $this->output($this->castInts($rows, ['id']));
    }

    public function kabupaten()
    {
        $q = \Config\Database::connect()->table('tbl_kabupaten')->select('id, id_provinsi, nama');

        $prov = $this->request->getGet('id_provinsi');
        if ($prov !== null && $prov !== '') {
            $q->where('id_provinsi', (int) $prov);
        }

        $rows = $q->orderBy('id', 'ASC')->get()->getResultArray();

        return $this->output($this->castInts($rows, ['id', 'id_provinsi']));
    }

    public function kecamatan()
    {
        $q = \Config\Database::connect()->table('tbl_kecamatan')->select('id, id_kabupaten, nama');

        $kab = $this->request->getGet('id_kabupaten');
        if ($kab !== null && $kab !== '') {
            $q->where('id_kabupaten', (int) $kab);
        }

        $rows = $q->orderBy('id', 'ASC')->get()->getResultArray();

        return $this->output($this->castInts($rows, ['id', 'id_kabupaten']));
    }

    public function wilayah()
    {
        // GeoJSON sengaja tidak ikut di daftar karena ukurannya besar
        $rows = \Config\Database::connect()->table('tbl_wilayah')
            ->select('id_wilayah, nama_wilayah, warna')
            ->orderBy('id_wilayah', 'ASC')->get()->getResultArray();

        return $this->output($this->castInts($rows, ['id_wilayah']));
    }

    public function wilayahDetail($id = null)
    {
        $row = \Config\Database::connect()->table('tbl_wilayah')
            ->where('id_wilayah', (int) $id)->get()->getRowArray();

        if (! $row) {
            return $this->failNotFound("Wilayah dengan id {$id} tidak ditemukan");
        }

        $row['id_wilayah'] = (int) $row['id_wilayah'];

        // Kolom geojson tersimpan sebagai teks; kirim sebagai objek JSON agar langsung bisa dipakai
        $decoded        = json_decode((string) $row['geojson'], true);
        $row['geojson'] = $decoded ?? $row['geojson'];

        return $this->respond([
            'status'  => 200,
            'message' => 'OK',
            'data'    => $row,
        ]);
    }

    /* ---------------------------- helper ---------------------------- */

    private function output(array $rows)
    {
        return $this->respond([
            'status'  => 200,
            'message' => 'OK',
            'total'   => count($rows),
            'data'    => $rows,
        ]);
    }

    private function castInts(array $rows, array $keys): array
    {
        foreach ($rows as &$row) {
            foreach ($keys as $k) {
                $row[$k] = ($row[$k] ?? null) !== null ? (int) $row[$k] : null;
            }
        }
        unset($row);

        return $rows;
    }
}
