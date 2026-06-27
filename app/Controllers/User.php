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

    public function Input()
    {
        $data = [
            'judul' => 'Input User',
            'page'  => 'user/v_input',
            'menu'  => 'user',
        ];
        return view('v_template_back_end', $data);
    }

    public function InsertData()
    {
        $foto = $this->request->getFile('foto_user');
        $nama_file = $foto->getRandomName();

        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email'     => $this->request->getPost('email'),
            'password'  => sha1($this->request->getPost('password')),
            'foto_user' => $nama_file,
        ];

        $foto->move('foto', $nama_file);
        $this->ModelUser->InsertData($data);

        session()->setFlashdata('insert', 'Data User Berhasil Ditambahkan !!!');
        return redirect()->to(base_url('admin/user'));
    }

  // =========================================================================
    // 🟢 FUNGSI EDIT (Menampilkan Halaman Form Edit)
    // =========================================================================
    public function Edit($id_user)
    {
        $data = [
            'judul' => 'Edit User',
            'page'  => 'user/v_edit',
            'menu'  => 'user',
            'user'  => $this->ModelUser->DetailData($id_user), // Mengambil data lama user
        ];
        return view('v_template_back_end', $data);
    }

    // =========================================================================
    // 🟢 FUNGSI UPDATE DATA (Proses Simpan Perubahan ke Database)
    // =========================================================================
    public function UpdateData($id_user)
    {
        $foto = $this->request->getFile('foto_user');

        // Jika user TIDAK mengganti foto baru (kosong)
        if ($foto->getError() == 4) {
            $data = [
                'id_user'   => $id_user,
                'nama_user' => $this->request->getPost('nama_user'),
                'email'     => $this->request->getPost('email'),
                'password'  => sha1($this->request->getPost('password')),
            ];
            $this->ModelUser->UpdateData($data); // Memanggil UpdateData dari model
        } else {
            // Jika user MENGGANTI foto baru, hapus berkas foto lama di server
            $user_lama = $this->ModelUser->DetailData($id_user);
            
            if ($user_lama && !empty($user_lama['foto_user'])) {
                if (file_exists('foto/' . $user_lama['foto_user'])) {
                    unlink('foto/' . $user_lama['foto_user']);
                }
            }

            // Simpan file foto baru ke folder 'foto'
            $nama_file = $foto->getRandomName();
            $data = [
                'id_user'   => $id_user,
                'nama_user' => $this->request->getPost('nama_user'),
                'email'     => $this->request->getPost('email'),
                'password'  => sha1($this->request->getPost('password')),
                'foto_user' => $nama_file,
            ];

            $foto->move('foto', $nama_file);
            $this->ModelUser->UpdateData($data); // Memanggil UpdateData dari model
        }

        session()->setFlashdata('insert', 'Data User Berhasil Diupdate !!!');
        return redirect()->to(base_url('admin/user'));
    }

    // =========================================================================
    // 🟢 FUNGSI HAPUS DATA (Proses Delete Data & Berkas Foto)
    // =========================================================================
    public function Hapus($id_user)
    {
        $user = $this->ModelUser->DetailData($id_user);
        
        // Hapus file gambar dari folder lokal sebelum record database dihapus
        if ($user && !empty($user['foto_user'])) {
            if (file_exists('foto/' . $user['foto_user'])) {
                unlink('foto/' . $user['foto_user']);
            }
        }

        $data = ['id_user' => $id_user];
        $this->ModelUser->DeleteData($data); // Menggunakan DeleteData() sesuai video menit 10:26
        
        session()->setFlashdata('insert', 'Data User Berhasil Dihapus !!!');
        return redirect()->to(base_url('admin/user'));
    }
}