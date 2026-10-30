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
            session()->set('log', true);
            session()->set('nama_user', $cek['nama_user']);
            session()->set('email', $cek['email']);
            session()->set('foto_user', $cek['foto_user']);

            return redirect()->to(base_url('admin/dashboard'));
        } else {
            session()->setFlashdata('pesan', 'Email atau Password Salah!');
            return redirect()->to(base_url('auth/login'));
        }
    }

    // Menampilkan Halaman Registrasi
    public function register()
    {
        return view('v_register');
    }

    // Proses Simpan Data Registrasi
    public function simpan_register()
    {
        $rules = [
            'nama_user' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => '{field} wajib diisi!',
                    'min_length' => '{field} minimal 3 karakter!',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[tbl_user.email]',
                'errors' => [
                    'required'    => '{field} wajib diisi!',
                    'valid_email' => 'Format {field} tidak valid!',
                    'is_unique'   => '{field} sudah terdaftar!',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required'   => '{field} wajib diisi!',
                    'min_length' => '{field} minimal 5 karakter!',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email'     => $this->request->getPost('email'),
            'password'  => sha1($this->request->getPost('password')),
            'foto_user' => 'default.jpg',
        ];

        $this->ModelUser->InsertData($data);

        session()->setFlashdata('pesan', 'Registrasi berhasil! Silakan log in.');
        return redirect()->to(base_url('auth/login'));
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
