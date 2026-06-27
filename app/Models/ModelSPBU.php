<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSPBU extends Model
{
public function AllData()
{
    return $this->db->table('tbl_spbu')
        // 🟢 Gabungkan tbl_spbu dengan tbl_jenis berdasarkan id_jenis
        ->join('tbl_jenis', 'tbl_jenis.id_jenis = tbl_spbu.id_jenis', 'left')
        ->orderBy('id_spbu', 'DESC')
        ->get()
        ->getResultArray();
}

   public function InsertData($data)
   {
        $this->db->table('tbl_spbu')->insert($data);
   }

   public function DetailData($id_spbu)
   {
        return $this->db->table('tbl_spbu')
                ->where('id_spbu', $id_spbu)
                ->get()->getRowArray();
   }
      public function UpdateData($data)
   {
        $this->db->table('tbl_spbu')
            ->where('id_spbu', $data['id_spbu'])
            ->update($data);
   }
   public function DeleteData($data)
{
    // Cek apakah nama tabelnya benar 'spbu'
    // Cek apakah nama primary key-nya benar 'id_spbu'
    return $this->db->table('tbl_spbu') // Ganti 'tbl_spbu' dengan nama tabelmu
                    ->where('id_spbu', $data['id_spbu'])
                    ->delete();
}
// 🟢 SINKRONISASI UNTUK DATA PROVINSI SPBU
    public function allProvinsi()
{
    return $this->db->table('tbl_provinsi')
        // 🟢 Diubah menjadi 'id' sesuai kolom di phpMyAdmin kamu
        ->orderBy('id', 'ASC') 
        ->get()->getResultArray();
}

public function allKabupaten($id_provinsi)
    {
        return $this->db->table('tbl_kabupaten')
            // 🟢 Ini mencocokkan id_provinsi yang dikirim dari View/Controller
            // dengan kolom relasi di dalam tabel tbl_kabupaten kamu
            ->where('id_provinsi', $id_provinsi)
            ->get()->getResultArray();
    }

    public function Kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        // 🟢 Disesuaikan dengan nama Model SPBU milikmu
        $kab = $this->ModelSPBU->allKabupaten($id_provinsi); 
        
        echo '<option value="">--Pilih Kabupaten--</option>';
        foreach ($kab as $key => $value) {
            // 🟢 Disesuaikan menjadi 'id' dan 'nama' sesuai kolom tabel tbl_kabupaten di phpMyAdmin kamu
            echo '<option value="' . $value['id'] . '">' . $value['nama'] . '</option>';
        }
    }
}
