<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJenis extends Model
{
    public function AllData()
   {
        return $this->db->table('tbl_jenis')
                ->get()->getResultArray();
   }

   public function InsertData($data)
   {
        $this->db->table('tbl_jenis')->insert($data);
   }

   public function DetailData($id_jenis)
   {
        return $this->db->table('tbl_jenis')
                ->where('id_wilayah', $id_jenis)
                ->get()->getRowArray();
   }
      public function UpdateData($data)
   {
        $this->db->table('tbl_jenis')
            ->where('id_jenis', $data['id_jenis'])
            ->update($data);
   }
   public function DeleteData($data)
{
    // Cek apakah nama tabelnya benar 'wilayah'
    // Cek apakah nama primary key-nya benar 'id_wilayah'
    return $this->db->table('tbl_jenis') // Ganti 'tbl_wilayah' dengan nama tabelmu
                    ->where('id_jenis', $data['id_jenis'])
                    ->delete();
}
}
