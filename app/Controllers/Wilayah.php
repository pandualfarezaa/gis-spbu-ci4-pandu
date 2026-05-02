<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;
class Wilayah extends BaseController
{
    protected $ModelWilayah;
    protected $ModelSetting;

    public function __construct()
    {
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelSetting = new ModelSetting();
    }

    public function index()
{
    $data = [
        'judul' => 'Wilayah',
        'page' => 'v_index',
        'wilayah' => $this->ModelWilayah->AllData(),
        'spbu' => $this->ModelSetting->DataSpbu(),
    ];

    return view('v_template_back_end', $data);
}

    public function Add()
    {
        $data = [
            'judul' => 'Input Wilayah',
            'page' => 'v_input',
        ];
        return view('v_template_back_end', $data);
    }

public function InsertData()
{
    $rules = [
        'nama_wilayah' => [
            'label' => 'Nama Wilayah',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!',
            ],
        ],
        'geojson' => [
            'label' => 'GeoJSON',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!',
            ],
        ],
        'warna' => [
            'label' => 'Warna',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!',
            ],
        ],
    ];

    // 🔥 VALIDASI HARUS DI ATAS
    if (!$this->validate($rules)) {
        return redirect()->to(base_url('wilayah/input'))
            ->withInput()
            ->with('validation', $this->validator);
    }

    // baru insert kalau lolos
    $data = [
        'nama_wilayah' => $this->request->getPost('nama_wilayah'),
        'geojson' => $this->request->getPost('geojson'),
        'warna' => $this->request->getPost('warna'),
    ];

    $this->ModelWilayah->InsertData($data);

    session()->setFlashdata('insert', 'Data berhasil disimpan!');

    return redirect()->to(base_url('admin/wilayah'));
}
}
