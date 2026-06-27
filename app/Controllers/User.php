<?php

namespace App\Controllers;

use App\Models\ModelUser;

class User extends BaseController
{
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $data = [
            'judul' => 'User',
            'page'  => 'user/v_index',
            'menu'  => 'user',
            'user'  => $this->ModelUser->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

    // 🟢 FUNGSI UNTUK PINDAH KE HALAMAN INPUT USER
    public function Input()
    {
        $data = [
            'judul' => 'Input User',
            'page'  => 'user/v_input',
            'menu'  => 'user',
        ];
        return view('v_template_back_end', $data);
    }

   // 🟢 FUNGSI SIMPAN DATA KE DATABASE (DENGAN ENKRIPSI SHA-1)
public function InsertData()
{
    $foto = $this->request->getFile('foto_user');
    $nama_file = $foto->getRandomName();

    $data = [
        'nama_user'   => $this->request->getPost('nama_user'),
        'email'       => $this->request->getPost('email'),
        'password'    => sha1($this->request->getPost('password')), // Menggunakan enkripsi SHA-1 sesuai video
        // 🟢 PERBAIKAN DI SINI: Wajib dibungkus tanda petik miring (backtick) agar spasinya aman di MySQL
        '`foto user`' => $nama_file, 
    ];

    $foto->move('foto', $nama_file);
    $this->ModelUser->InsertData($data);

    session()->setFlashdata('insert', 'Data User Berhasil Ditambahkan !!!');
    return redirect()->to(base_url('admin/user'));
}
}