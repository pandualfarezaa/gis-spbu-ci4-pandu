<?php

namespace App\Controllers;

use App\Models\ModelSetting;

class Admin extends BaseController
{
    protected $ModelSetting;
    public function __construct()
    {
        $this->ModelSetting = new ModelSetting();
    }
    
    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard',
            'menu'  => 'dashboard',
            'page' => 'v_dashboard',
        ];
        return view('v_template_back_end', $data);
    }

    public function setting(): string
    {
        $data = [
            'judul' => 'Setting',
            'menu'  => 'setting',
            'page' => 'v_setting',
            'spbu' => $this->ModelSetting->DataSpbu(),
        ];
        return view('v_template_back_end', $data);
    }
        public function UpdateSetting()
    {
        $data = [
            'id' => 1, 
            'nama_spbu' => $this->request->getPost('nama_spbu'),
            'coordinat_wilayah' => $this->request->getPost('coordinat_wilayah'),
            'zoom_view' => $this->request->getPost('zoom_view'),
        ];

        $this->ModelSetting->UpdateData($data);
        session()->setFlashdata('pesan', 'Settingan SPBU Telah Diupdate !!!');
        return redirect()->to(base_url('admin/setting'));
    }
}
