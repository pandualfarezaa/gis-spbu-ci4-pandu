<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSetting extends Model
{
    // 🟢 Membaca Data Pengaturan Web (Koordinat Pusat, Zoom, Nama Web, dll)
    public function DataSetting()
    {
        return $this->db->table('tbl_setting')
                ->where('id', 1)
                ->get()->getRowArray();
    }

   // 🟢 Membaca Semua Data 3 SPBU Kamu untuk Digambar Jadi Marker Kustom
    public function DataSpbu()
    {
        return $this->db->table('tbl_spbu')
            ->select('tbl_spbu.*, tbl_wilayah.nama_wilayah, tbl_jenis.jenis, tbl_jenis.marker') 
            ->join('tbl_wilayah', 'tbl_wilayah.id_wilayah = tbl_spbu.id_wilayah', 'left')
            ->join('tbl_jenis', 'tbl_jenis.id_jenis = tbl_spbu.id_jenis', 'left')
            ->get()->getResultArray(); 
    }

    // 🟢 Mengupdate Data Pengaturan Web
    public function UpdateData($data)
    {
        $this->db->table('tbl_setting')
            ->where('id', 1)
            ->update($data);
    }
}