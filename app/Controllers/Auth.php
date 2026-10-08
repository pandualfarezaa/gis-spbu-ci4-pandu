<?php

namespace App\Controllers;

use App\Models\ModelUser;

class Auth extends BaseController
{
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }

    // Menampilkan Halaman Login
    public function login()
    {
        return view('v_login');
    }

    // Validasi Akun Saat Tombol Log In Ditekan
    public function cek_login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $cek = $this->ModelUser->loginUser($email, $password);

        if ($cek) {
            // Jika data cocok, buat session data user tersebut
            session()->set('log', true);
            session()->set('nama_user', $cek['nama_user']);
            session()->set('email', $cek['email']);
            session()->set('foto_user', $cek['foto_user']);

            // Alihkan ke halaman dashboard admin
            return redirect()->to(base_url('admin/dashboard'));
        } else {
            // Jika gagal, kembalikan ke login dengan pesan error
            session()->setFlashdata('pesan', 'Email atau Password Salah!');
            return redirect()->to(base_url('auth/login'));
        }
    }

    // Fungsi Log Out
    public function logout()
    {
        session()->remove('log');
        session()->remove('nama_user');
        session()->remove('email');
        session()->remove('foto_user');
        
        session()->setFlashdata('pesan', 'Anda Berhasil Log Out.');
        return redirect()->to(base_url('auth/login'));
    }
}