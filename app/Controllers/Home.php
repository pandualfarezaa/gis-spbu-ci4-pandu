<?php

namespace App\Controllers;
use App\Models\ModelSetting;
use App\Models\ModelWilayah;

class Home extends BaseController
{
    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
        $this->ModelWilayah = new ModelWilayah();
    }

 public function index(): string
{
    // 🟢 Ambil data setting secara tunggal (satu baris) menggunakan getRowArray()
    // Catatan: Pastikan di dalam ModelSetting kamu ada fungsi bernama 'DataSetting()' 
    // atau sesuaikan dengan fungsi yang mengambil data dari 'tbl_setting'
    $db = \Config\Database::connect();
    $setting = $db->table('tbl_setting')->where('id', 1)->get()->getRowArray();

    $data = [
        'judul' => 'Home',
        'page'  => 'v_home',
        'spbu'  => $this->ModelSetting->DataSpbu(), // Tetap ada untuk marker spbu nanti
        'web'   => $setting, // 🟢 Dikirim sebagai $web, persis seperti di tutor!
        'wilayah' => $this->ModelWilayah->AllData(),
    ];
    return view('v_template_front_end', $data);
}
}
