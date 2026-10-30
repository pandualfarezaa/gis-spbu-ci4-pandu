<?php

namespace App\Controllers;

class Feedback extends BaseController
{
    /**
     * Simpan feedback umum (bukan untuk SPBU tertentu)
     */
    public function simpanUmum()
    {
        $db = \Config\Database::connect();

        $data = [
            'nama'       => $this->request->getPost('nama') ?? 'Anonim',
            'email'      => $this->request->getPost('email'),
            'pesan'      => $this->request->getPost('pesan'),
            'tipe'       => 'umum',
            'id_spbu'    => null,
            'status'     => 'tampil',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $db->table('tbl_feedback')->insert($data);

        session()->setFlashdata('pesan', 'Terima kasih atas feedback Anda!');
        return redirect()->back();
    }

    /**
     * Simpan feedback untuk SPBU tertentu
     */
    public function simpanSpbu($id_spbu)
    {
        $db = \Config\Database::connect();

        $data = [
            'nama'       => $this->request->getPost('nama') ?? 'Anonim',
            'email'      => $this->request->getPost('email'),
            'pesan'      => $this->request->getPost('pesan'),
            'tipe'       => 'spbu',
            'id_spbu'    => $id_spbu,
            'status'     => 'tampil',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $db->table('tbl_feedback')->insert($data);

        session()->setFlashdata('pesan', 'Terima kasih atas feedback Anda!');
        return redirect()->back();
    }
}
