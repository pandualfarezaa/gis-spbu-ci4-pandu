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
            'menu'  => 'wilayah',
            'page' => 'wilayah/v_index',
            'wilayah' => $this->ModelWilayah->AllData(),
            'spbu' => $this->ModelSetting->DataSpbu(),
        ];

        return view('v_template_back_end', $data);
    }

    public function Input()
    {
        $data = [
            'judul' => 'Tambah Wilayah',
            'menu'  => 'wilayah',
            'page' => 'wilayah/v_input',
            'spbu' => $this->ModelSetting->DataSpbu(), // Dikirim agar peta di layout tidak crash
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

        // 🔥 VALIDASI TAMBAH DATA (Kembali ke halaman input)
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Jalankan insert jika validasi lolos
        $data = [
            'nama_wilayah' => $this->request->getPost('nama_wilayah'),
            'geojson' => $this->request->getPost('geojson'),
            'warna' => $this->request->getPost('warna'),
        ];

        // Memanggil fungsi InsertData dari Model
        $this->ModelWilayah->InsertData($data);

        session()->setFlashdata('insert', 'Data berhasil disimpan!');

        return redirect()->to(base_url('admin/wilayah'));
    }

    public function Edit($id_wilayah)
    {
        $data = [
            'judul' => 'Edit Wilayah',
            'menu'  => 'wilayah',
            'page' => 'wilayah/v_edit',
            'wilayah' => $this->ModelWilayah->DetailData($id_wilayah),
            'spbu' => $this->ModelSetting->DataSpbu(), // Dikirim agar peta di layout tidak crash
        ];
        return view('v_template_back_end', $data);
    }

    public function UpdateData($id_wilayah)
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

        // 🔥 VALIDASI EDIT DATA (Kembali ke halaman edit berdasarkan ID)
        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/wilayah/edit/' . $id_wilayah))->withInput();
        }

        // Jalankan update jika validasi lolos
        $data = [
            'id_wilayah' => $id_wilayah,
            'nama_wilayah' => $this->request->getPost('nama_wilayah'),
            'geojson' => $this->request->getPost('geojson'),
            'warna' => $this->request->getPost('warna'),
        ];

        $this->ModelWilayah->UpdateData($data);

        session()->setFlashdata('update', 'Data berhasil diperbarui!!');

        return redirect()->to(base_url('admin/wilayah'));
    }
}