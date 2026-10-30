<?php

namespace App\Controllers;

class AdminFeedback extends BaseController
{
    /**
     * Halaman daftar semua feedback (admin)
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $feedback = $db->table('tbl_feedback')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        $data = [
            'judul'    => 'Feedback',
            'menu'     => 'feedback',
            'page'     => 'feedback/v_index',
            'feedback' => $feedback,
        ];

        return view('v_template_back_end', $data);
    }

    /**
     * Sembunyikan feedback (set status = 'sembunyi')
     */
    public function sembunyikan($id)
    {
        $db = \Config\Database::connect();
        $db->table('tbl_feedback')->where('id_feedback', $id)->update(['status' => 'sembunyi']);

        session()->setFlashdata('pesan', 'Feedback berhasil disembunyikan.');
        return redirect()->to(base_url('admin/feedback'));
    }

    /**
     * Tampilkan kembali feedback (set status = 'tampil')
     */
    public function tampilkan($id)
    {
        $db = \Config\Database::connect();
        $db->table('tbl_feedback')->where('id_feedback', $id)->update(['status' => 'tampil']);

        session()->setFlashdata('pesan', 'Feedback berhasil ditampilkan kembali.');
        return redirect()->to(base_url('admin/feedback'));
    }

    /**
     * Hapus feedback permanen
     */
    public function hapus($id)
    {
        $db = \Config\Database::connect();
        $db->table('tbl_feedback')->where('id_feedback', $id)->delete();

        session()->setFlashdata('pesan', 'Feedback berhasil dihapus.');
        return redirect()->to(base_url('admin/feedback'));
    }
}
