<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;
use App\Models\ModelSPBU;

class SPBU extends BaseController
{
    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelSPBU = new ModelSPBU();
    }

    public function index()
    {
         $data = [
            'judul' => 'SPBU',
            'menu'  => 'spbu',
            'page' => 'spbu/v_index',
            'spbu' => $this->ModelSPBU->AllData(),
        ];

        return view('v_template_back_end', $data);
    }

public function Input()
{
    // Mengambil data dari tbl_setting agar halaman input bisa membaca pusat petanya
    $db = \Config\Database::connect();
    $setting = $db->table('tbl_setting')->where('id', 1)->get()->getRowArray();

    // Tarik data wilayah dari database biar bisa di-render Leaflet!
    $wilayah = $db->table('tbl_wilayah')->get()->getResultArray();

    // Tarik data langsung dari tbl_provinsi sesuai yang ada di databasemu
    $provinsi = $db->table('tbl_provinsi')->orderBy('id', 'ASC')->get()->getResultArray();

    // 🟢 TAMBAHKAN BARIS INI: Mengambil data jenis SPBU dari tabel tbl_jenis
    $jenis = $db->table('tbl_jenis')->orderBy('id_jenis', 'ASC')->get()->getResultArray();

    $data = [
        'judul'      => 'Input Data SPBU',
        'page'       => 'spbu/v_input',
        'web'        => $setting, // Untuk setelan peta
        'menu'       => 'spbu',
        'wilayah'    => $wilayah, // Tetap dikirim untuk kebutuhan peta Leaflet
        'provinsi'   => $provinsi, 
        
        // 🟢 TAMBAHKAN BARIS INI: Kirim variabel jenis ke file v_input.php
        'jenis'      => $jenis, 
           
        // DEFINISIKAN LANGSUNG DI SINI (Cara awal yang terbukti aman)
        'validation' => \Config\Services::validation(), 
    ];
    return view('v_template_back_end', $data);
}

 public function Edit($id_spbu)
{
    $db = \Config\Database::connect();

    // 1. Ambil data SPBU lama yang mau diedit berdasarkan ID-nya
    $spbu = $db->table('tbl_spbu')->where('id_spbu', $id_spbu)->get()->getRowArray();

    // 2. Ambil data pendukung peta & wilayah
    $setting = $db->table('tbl_setting')->where('id', 1)->get()->getRowArray();
    $provinsi = $db->table('tbl_provinsi')->orderBy('id', 'ASC')->get()->getResultArray();
    $jenis = $db->table('tbl_jenis')->orderBy('id_jenis', 'ASC')->get()->getResultArray();

    $data = [
        'judul'      => 'Edit Data SPBU',
        'page'       => 'spbu/v_edit', 
        'web'        => $setting,
        'spbu'       => $spbu,
        'provinsi'   => $provinsi,
        'jenis'      => $jenis,
        'validation' => \Config\Services::validation(), 
        
        // 🟢 TAMBAHKAN BARIS INI AGAR SIDEBAR TIDAK ERROR UNDEFINED
        'menu'       => 'spbu', 
    ];

    return view('v_template_back_end', $data); 
}

public function InsertData()
{
    if ($this->validate([
        'nama_spbu' => [
            'label' => 'Nama SPBU',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        // 🟢 TAMBAHKAN VALIDASI UNTUK JENIS SPBU
        'id_jenis' => [
            'label' => 'Jenis SPBU',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'id_provinsi' => [
            'label' => 'Provinsi',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'id_kabupaten' => [
            'label' => 'Kabupaten',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'id_kecamatan' => [
            'label' => 'Kecamatan',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'alamat' => [
            'label' => 'Alamat',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'koordinat' => [
            'label' => 'Koordinat',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'id_wilayah' => [
            'label' => 'Wilayah Administrasi',
            'rules' => 'required',
            'errors' => ['required' => '{field} Wajib Diisi !!']
        ],
        'foto' => [
            'label' => 'Foto SPBU',
            'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => '{field} Wajib Diisi !!',
                'max_size' => 'Ukuran {field} maksimal 1024 KB !!',
                'mime_in' => 'Format {field} Harus JPG, JPEG, PNG !!',
            ]
        ],
    ])) {
        // JIKA VALIDASI BERHASIL
        $foto = $this->request->getFile('foto');
        $nama_file_foto = $foto->getRandomName();

        $data = [
            'nama_spbu'    => $this->request->getPost('nama_spbu'),
            
            // 🟢 TAMBAHKAN BARIS INI: Menyimpan ID Jenis ke kolom id_jenis database
            'id_jenis'     => $this->request->getPost('id_jenis'),
            
            'id_provinsi'  => $this->request->getPost('id_provinsi'),
            'id_kabupaten' => $this->request->getPost('id_kabupaten'),
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
            'alamat'       => $this->request->getPost('alamat'),
            'lokasi'       => $this->request->getPost('koordinat'), 
            'id_wilayah'   => $this->request->getPost('id_wilayah'),
            'foto'         => $nama_file_foto,
        ];

        // Pindahkan file gambar fisik ke folder public/foto/
        $foto->move('foto', $nama_file_foto);

        $db = \Config\Database::connect();
        $db->table('tbl_spbu')->insert($data);

        // 🟢 PASTIKAN DUA BARIS INI DITULIS SEPERTI INI:
        session()->setFlashdata('insert', 'Data SPBU Berhasil Ditambahkan !!!');
        return redirect()->to(base_url('admin/spbu')); 
    } else {
        return redirect()->to(base_url('admin/spbu/input'))->withInput();
    }
}

public function UpdateData($id_spbu)
{
    $db = \Config\Database::connect();
    
    // Ambil data lama dulu untuk keperluan pengecekan foto
    $spbu_lama = $db->table('tbl_spbu')->where('id_spbu', $id_spbu)->get()->getRowArray();

    $foto = $this->request->getFile('foto');

    // Cek apakah user mengupload foto baru atau tidak
    if ($foto->getError() == 4) {
        // Jika tidak upload foto baru, pakai nama foto yang lama
        $nama_file_foto = $spbu_lama['foto'];
    } else {
        // Jika upload foto baru, acak nama baru dan hapus file foto lama di folder lokal
        $nama_file_foto = $foto->getRandomName();
        if (file_exists('foto/' . $spbu_lama['foto'])) {
            unlink('foto/' . $spbu_lama['foto']);
        }
        $foto->move('foto', $nama_file_foto);
    }

    $data = [
        'nama_spbu'    => $this->request->getPost('nama_spbu'),
        'id_jenis'     => $this->request->getPost('id_jenis'),
        'id_provinsi'  => $this->request->getPost('id_provinsi'),
        'id_kabupaten' => $this->request->getPost('id_kabupaten'),
        'id_kecamatan' => $this->request->getPost('id_kecamatan'),
        'alamat'       => $this->request->getPost('alamat'),
        'lokasi'       => $this->request->getPost('koordinat'), 
        'id_wilayah'   => $this->request->getPost('id_wilayah'),
        'rest_area'    => $this->request->getPost('rest_area'),
        'status'       => $this->request->getPost('status'),
        'foto'         => $nama_file_foto,
    ];

    // Eksekusi Update data berdasarkan ID SPBU
    $db->table('tbl_spbu')->where('id_spbu', $id_spbu)->update($data);

    session()->setFlashdata('insert', 'Data SPBU Berhasil Diperbarui !!!');
    return redirect()->to('admin/spbu');
}

public function Kabupaten()
{
    $id_provinsi = $this->request->getPost('id_provinsi');
    $db = \Config\Database::connect();

    // Mengambil data dari tbl_kabupaten berdasarkan id_provinsi yang dipilih
    $kabupaten = $db->table('tbl_kabupaten')
                    ->where('id_provinsi', $id_provinsi)
                    ->orderBy('nama', 'ASC')
                    ->get()
                    ->getResultArray();

    // Cetak opsi HTML untuk dikembalikan ke AJAX
    echo '<option value="">--Pilih Kabupaten--</option>';
    foreach ($kabupaten as $key => $value) {
        echo '<option value="' . $value['id'] . '">' . $value['nama'] . '</option>';
    }
}
   
 public function Kecamatan()
{
    $id_kabupaten = $this->request->getPost('id_kabupaten');
    $db = \Config\Database::connect();

    $kecamatan = $db->table('tbl_kecamatan')
                    ->where('id_kabupaten', $id_kabupaten)
                    ->orderBy('nama', 'ASC')
                    ->get()
                    ->getResultArray();

    // 🟢 Kita cetak HTML dua kali dengan pembatas (separator) khusus agar gampang dipisah di JavaScript
    
    // Bagian 1: Untuk Dropdown Kecamatan Asli
    echo '<option value="">--Pilih Kecamatan--</option>';
    foreach ($kecamatan as $key => $value) {
        echo '<option value="' . $value['id'] . '">' . $value['nama'] . '</option>';
    }

    echo "||SPLIT_DISINI||"; // <--- Pembatas unik

    // Bagian 2: Untuk Dropdown Wilayah Administrasi
    echo '<option value="">--Pilih Wilayah Administrasi--</option>';
    foreach ($kecamatan as $key => $value) {
        // Menyisipkan kata "Kecamatan " di depan namanya seperti di video tutorial
        echo '<option value="' . $value['id'] . '">Kecamatan ' . $value['nama'] . '</option>';
    }
}

public function Detail($id_spbu)
{
    $db = \Config\Database::connect();

    // 1. Ambil detail data SPBU dan join ke tbl_jenis agar nama jenisnya tampil
    $spbu = $db->table('tbl_spbu')
                ->join('tbl_jenis', 'tbl_jenis.id_jenis = tbl_spbu.id_jenis', 'left')
                ->where('id_spbu', $id_spbu)
                ->get()
                ->getRowArray();

    // 2. Ambil data tbl_setting untuk kebutuhan konfigurasi peta Leaflet
    $setting = $db->table('tbl_setting')->where('id', 1)->get()->getRowArray();

    $data = [
        'judul' => 'Detail Data SPBU : ' . $spbu['nama_spbu'],
        'page'  => 'spbu/v_detail', 
        'menu'  => 'spbu',
        'spbu'  => $spbu,
        'web'   => $setting, // Dikirim ke view untuk setting map Leaflet
    ];

    return view('v_template_back_end', $data); 
}

public function Delete($id_spbu)
{
    $db = \Config\Database::connect();

    // 1. Ambil data SPBU untuk menghapus file foto fisiknya agar tidak nyampah di hosting/lokal
    $spbu = $db->table('tbl_spbu')->where('id_spbu', $id_spbu)->get()->getRowArray();
    
    if (file_exists('foto/' . $spbu['foto'])) {
        unlink('foto/' . $spbu['foto']);
    }

    // 2. Eksekusi hapus data dari database berdasarkan ID SPBU
    $db->table('tbl_spbu')->where('id_spbu', $id_spbu)->delete();

    // 3. Set notifikasi sukses dan kembalikan ke halaman utama tabel
    session()->setFlashdata('insert', 'Data SPBU Berhasil Dihapus !!!');
    return redirect()->to(base_url('admin/spbu'));
}

}
