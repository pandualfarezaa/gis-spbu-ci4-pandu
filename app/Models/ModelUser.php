<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    // Fungsi untuk menampilkan semua data user di tabel utama
    public function AllData()
    {
        return $this->db->table('tbl_user')
            ->get()
            ->getResultArray();
    }

    // Fungsi untuk menyimpan data user baru dari modal form
    public function InsertData($data)
    {
        $this->db->table('tbl_user')->insert($data);
    }

    // Fungsi untuk mengambil data 1 user spesifik berdasarkan id_user
    public function DetailData($id_user)
    {
        return $this->db->table('tbl_user')
            ->where('id_user', $id_user)
            ->get()
            ->getRowArray();
    }

    // Fungsi untuk memperbarui/mengubah data user (Update)
    public function UpdateData($data)
    {
        $this->db->table('tbl_user')
            ->where('id_user', $data['id_user'])
            ->update($data);
    }

    // Fungsi untuk menghapus data user dari database
    public function DeleteData($data)
    {
        $this->db->table('tbl_user')
            ->where('id_user', $data['id_user'])
            ->delete();
    }
}