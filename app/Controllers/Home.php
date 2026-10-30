<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelWilayah;
use App\Models\ModelJenis;
use App\Models\ModelSPBU;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelWilayah;
    protected $ModelJenis;
    protected $ModelSPBU;

    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelJenis = new ModelJenis();
        $this->ModelSPBU = new ModelSPBU();
    }

    public function index(): string
    {
        $setting = $this->ModelSetting->DataSetting();
        $rawSpbu = $this->ModelSetting->DataSpbu();
        $cleanSpbu = [];

        if (is_array($rawSpbu)) {
            foreach ($rawSpbu as $s) {
                $cleanSpbu[] = $s;
            }
        }

        $data = [
            'judul'   => 'Home',
            'page'    => 'v_home',
            'web'     => $setting, 
            'wilayah' => $this->ModelWilayah->AllData(),
            'jenis'   => $this->ModelJenis->AllData(), 
            'spbu'    => $cleanSpbu, 
        ];

        return view('v_template_front_end', $data);
    }

    // 🟢 FITUR BARU: Filter Berdasarkan Wilayah (Brebes / Banyumas)
    public function wilayah($id_wilayah): string
    {
        $setting = $this->ModelSetting->DataSetting();
        $rawSpbu = $this->ModelSetting->DataSpbu();
        $cleanSpbu = [];

        if (is_array($rawSpbu)) {
            foreach ($rawSpbu as $s) {
                // Hanya masukkan SPBU yang cocok dengan ID Wilayah yang dipilih
                if (isset($s['id_wilayah']) && $s['id_wilayah'] == $id_wilayah) {
                    $cleanSpbu[] = $s;
                }
            }
        }

        $data = [
            'judul'   => 'Filter Wilayah',
            'page'    => 'v_home',
            'web'     => $setting, 
            'wilayah' => $this->ModelWilayah->AllData(),
            'jenis'   => $this->ModelJenis->AllData(), 
            'spbu'    => $cleanSpbu, 
        ];

        return view('v_template_front_end', $data);
    }

    // 🟢 FITUR BARU: Filter Berdasarkan Jenis (SPBU / Pertashop)
    public function jenis($id_jenis): string
    {
        $setting = $this->ModelSetting->DataSetting();
        $rawSpbu = $this->ModelSetting->DataSpbu();
        $cleanSpbu = [];

        if (is_array($rawSpbu)) {
            foreach ($rawSpbu as $s) {
                // Hanya masukkan SPBU yang cocok dengan ID Jenis yang dipilih
                if (isset($s['id_jenis']) && $s['id_jenis'] == $id_jenis) {
                    $cleanSpbu[] = $s;
                }
            }
        }

        $data = [
            'judul'   => 'Filter Jenis SPBU',
            'page'    => 'v_home',
            'web'     => $setting, 
            'wilayah' => $this->ModelWilayah->AllData(),
            'jenis'   => $this->ModelJenis->AllData(), 
            'spbu'    => $cleanSpbu, 
        ];

        return view('v_template_front_end', $data);
    }

    public function detail($id_spbu): string
    {
        $spbu = $this->ModelSPBU->DetailData($id_spbu);

        if (! $spbu) {
            throw PageNotFoundException::forPageNotFound('Data SPBU tidak ditemukan.');
        }

        return view('v_template_front_end', [
            'judul'   => 'Detail SPBU: ' . $spbu['nama_spbu'],
            'page'    => 'spbu/v_detail',
            'public'  => true,
            'web'     => $this->ModelSetting->DataSetting() ?? [],
            'wilayah' => $this->ModelWilayah->AllData(),
            'jenis'   => $this->ModelJenis->AllData(),
            'spbu'    => $spbu,
        ]);
    }
}
