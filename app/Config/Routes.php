<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes otomatis
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/setting', 'Admin::setting');
$routes->post('/admin/update-setting', 'Admin::UpdateSetting');

// 🟢 KELOMPOK RUTE WILAYAH (Sudah disesuaikan dengan Controller & v_edit)
$routes->get('admin/wilayah', 'Wilayah::index');              // Halaman Utama
$routes->get('admin/wilayah/input', 'Wilayah::Input');        // Form Tambah
$routes->post('admin/wilayah/simpan', 'Wilayah::InsertData');  // Proses Simpan Data

// ⚙️ PERBAIKAN DI SINI: (:any) diubah jadi (:num) agar lebih aman membaca ID berupa angka, 
// dan URL update disamakan menjadi 'updatedata' sesuai form di v_edit.php
$routes->get('admin/wilayah/edit/(:num)', 'Wilayah::Edit/$1'); 
$routes->post('admin/wilayah/updatedata/(:num)', 'Wilayah::UpdateData/$1'); 
$routes->get('admin/wilayah/delete/(:num)', 'Wilayah::Delete/$1');

// ... rute wilayah dan setting yang sudah ada ...

// ... rute admin/setting dan admin/wilayah yang sudah ada ...

// 🟢 KELOMPOK RUTE USER (Tambahkan di sini)
$routes->get('admin/user', 'User::index');              // Halaman Utama/Tabel User
$routes->get('admin/user/input', 'User::Input');        // Form Tambah User
$routes->post('admin/user/simpan', 'User::InsertData');  // Proses Simpan User
$routes->get('admin/user/edit/(:num)', 'User::Edit/$1'); // Form Edit User
$routes->post('admin/user/updatedata/(:num)', 'User::UpdateData/$1'); // Proses Update User
$routes->get('admin/user/delete/(:num)', 'User::Delete/$1'); // Proses Hapus User

// ... rute wilayah, setting, dan user yang sudah ada ...

// 🟢 KELOMPOK RUTE SPBU YANG SUDAH DIPERBAIKI (Ganti semua rute SPBU lamamu dengan ini)
$routes->get('admin/spbu', 'SPBU::index');
$routes->get('admin/spbu/input', 'SPBU::Input');
$routes->post('admin/spbu/insertdata', 'SPBU::InsertData');
$routes->get('admin/spbu/edit/(:num)', 'SPBU::Edit/$1');
$routes->post('admin/spbu/updatedata/(:num)', 'SPBU::UpdateData/$1');
$routes->get('admin/spbu/delete/(:num)', 'SPBU::Delete/$1');
$routes->post('admin/spbu/kabupaten', 'SPBU::Kabupaten');
$routes->post('admin/spbu/kecamatan', 'SPBU::Kecamatan');
$routes->get('admin/spbu/detail/(:num)', 'SPBU::Detail/$1');

// ... rute wilayah, setting, user, dan spbu yang sudah ada ...

// 🟢 KELOMPOK RUTE JENIS SPBU (Sudah ditambah pelindung untuk 'admin/jenis')
$routes->get('admin/jenis', 'JenisSpbu::index');              // <-- TAMBAHKAN BARIS INI
$routes->get('admin/jenis_spbu', 'JenisSpbu::index');         // Halaman Utama / Tabel Jenis SPBU
$routes->get('admin/jenis_spbu/input', 'JenisSpbu::Input');        // Form Tambah Jenis SPBU
$routes->post('admin/jenis_spbu/simpan', 'JenisSpbu::InsertData');  // Proses Simpan Jenis SPBU
$routes->get('admin/jenis_spbu/edit/(:num)', 'JenisSpbu::Edit/$1'); // Form Edit Jenis SPBU
$routes->post('admin/jenis_spbu/updatedata/(:num)', 'JenisSpbu::UpdateData/$1'); // Proses Update Jenis SPBU
$routes->get('admin/jenis_spbu/delete/(:num)', 'JenisSpbu::Delete/$1'); // Proses Hapus Jenis SPBU


//USER
$routes->get('admin/user', 'User::index');
$routes->get('admin/user/input', 'User::Input'); // 🟢 Rute halaman input baru
$routes->post('admin/user/insertdata', 'User::InsertData');
$routes->get('admin/user/delete/(:num)', 'User::Hapus/$1');
$routes->get('admin/user/hapus/(:num)', 'User::Hapus/$1'); // Tambahkan ini juga biar aman dua-duanya

// Rute untuk proses Auth
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/cek_login', 'Auth::cek_login');
$routes->get('auth/logout', 'Auth::logout');// Tambahkan baris ini di Routes.php jika belum ada
$routes->get('admin/dashboard', 'Admin::index'); 
// 💡 Catatan: Sesuaikan 'Admin::index' dengan nama Controller dan fungsi dashboard kamu. 
// Jika nama controllernya Dashboard.php, ubah menjadi 'Dashboard::index'.

// Rute untuk halaman utama (root)
$routes->get('/', 'Home::index');

// 🟢 TAMBAHKAN INI: Biar saat klik menu 'Home' atau akses /home tidak 404 lagi
$routes->get('home', 'Home::index');

// Rute untuk filter yang kita buat kemarin
$routes->get('home/wilayah/(:num)', 'Home::wilayah/$1');
$routes->get('home/jenis/(:num)', 'Home::jenis/$1');
// Tambahkan baris ini ke Routes.php
$routes->get('home/detail/(:num)', 'Home::detail/$1');

// Jika Controller Wilayah kamu berada di folder Controllers utama:
$routes->get('admin/wilayah/delete/(:num)', 'Wilayah::Hapus/$1');

// ATAU jika Controller Wilayah kamu berada di dalam sub-folder Admin (App\Controllers\Admin):
// $routes->get('admin/wilayah/delete/(:num)', 'Admin\Wilayah::Hapus/$1');

$routes->post('feedback/umum', 'Feedback::simpanUmum');
$routes->post('feedback/spbu/(:any)', 'Feedback::simpanSpbu/$1');

$routes->get('admin/feedback', 'AdminFeedback::index');
$routes->get('admin/feedback/sembunyikan/(:num)', 'AdminFeedback::sembunyikan/$1');
$routes->get('admin/feedback/tampilkan/(:num)', 'AdminFeedback::tampilkan/$1');
$routes->get('admin/feedback/hapus/(:num)', 'AdminFeedback::hapus/$1');

$routes->post('home/kirim_feedback', 'Home::kirim_feedback');


