<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelJenis;

class JenisSPBU extends BaseController
{
    public function __construct()
    {
        $this->ModelJenis = new ModelJenis();
    }

    public function index()
{
         $data = [
        'judul'     => 'Jenis SPBU',
        'menu'      => 'jenis_spbu',
        'page'      => 'v_jenis_spbu', // 🟢 DISESUAIKAN: Pakai garis bawah agar cocok dengan nama file kamu
        'jenisSpbu' => $this->ModelJenis->AllData(),
    ];
        return view('v_template_back_end', $data);
    }

   public function UpdateData($id_jenis)
{
    $marker = $this->request->getFile('marker');
    $name_file = $marker->getRandomName();
    $data = [
        'id_jenis' => $id_jenis,
        'marker'   => $name_file,
    ];
    $marker->move('marker', $name_file);
    $this->ModelJenis->UpdateData($data);

    // Menambahkan notifikasi sukses dan return redirect sesuai instruksi video
    session()->setFlashdata('update', 'Marker Berhasil Diupdate !!');
    return redirect()->to('admin/jenis_spbu');
}
}