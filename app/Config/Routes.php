<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes otomatis
$routes->setAutoRoute(false);

// Rute untuk halaman utama (root)
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home/wilayah/(:num)', 'Home::wilayah/$1');
$routes->get('home/jenis/(:num)', 'Home::jenis/$1');
$routes->get('home/detail/(:num)', 'Home::detail/$1');

// Rute untuk proses Auth
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/cek_login', 'Auth::cek_login');
$routes->get('auth/logout', 'Auth::logout');

// Admin Dashboard & Setting
$routes->get('/admin', 'Admin::index');
$routes->get('admin/dashboard', 'Admin::index');
$routes->get('/admin/setting', 'Admin::setting');
$routes->post('/admin/update-setting', 'Admin::UpdateSetting');

// 🟢 KELOMPOK RUTE WILAYAH
$routes->get('admin/wilayah', 'Wilayah::index');
$routes->get('admin/wilayah/input', 'Wilayah::Input');
$routes->post('admin/wilayah/simpan', 'Wilayah::InsertData');
$routes->get('admin/wilayah/edit/(:num)', 'Wilayah::Edit/$1');
$routes->post('admin/wilayah/updatedata/(:num)', 'Wilayah::UpdateData/$1');
$routes->get('admin/wilayah/delete/(:num)', 'Wilayah::delete/$1');

// 🟢 KELOMPOK RUTE USER
$routes->get('admin/user', 'User::index');
$routes->get('admin/user/input', 'User::Input');
$routes->post('admin/user/simpan', 'User::InsertData');
$routes->post('admin/user/insertdata', 'User::InsertData');
$routes->get('admin/user/edit/(:num)', 'User::Edit/$1');
$routes->post('admin/user/updatedata/(:num)', 'User::UpdateData/$1');
$routes->get('admin/user/delete/(:num)', 'User::Hapus/$1');
$routes->get('admin/user/hapus/(:num)', 'User::Hapus/$1');

// 🟢 KELOMPOK RUTE SPBU
$routes->get('admin/spbu', 'SPBU::index');
$routes->get('admin/spbu/input', 'SPBU::Input');
$routes->post('admin/spbu/insertdata', 'SPBU::InsertData');
$routes->get('admin/spbu/edit/(:num)', 'SPBU::Edit/$1');
$routes->post('admin/spbu/updatedata/(:num)', 'SPBU::UpdateData/$1');
$routes->get('admin/spbu/delete/(:num)', 'SPBU::Delete/$1');
$routes->post('admin/spbu/kabupaten', 'SPBU::Kabupaten');
$routes->post('admin/spbu/kecamatan', 'SPBU::Kecamatan');
$routes->get('admin/spbu/detail/(:num)', 'SPBU::Detail/$1');

// 🟢 KELOMPOK RUTE JENIS SPBU
$routes->get('admin/jenis', 'JenisSpbu::index');
$routes->get('admin/jenis_spbu', 'JenisSpbu::index');
$routes->post('admin/jenis_spbu/updatedata/(:num)', 'JenisSpbu::UpdateData/$1');

// 🟢 KELOMPOK RUTE FEEDBACK
$routes->post('feedback/umum', 'Feedback::simpanUmum');
$routes->post('feedback/spbu/(:any)', 'Feedback::simpanSpbu/$1');
$routes->get('admin/feedback', 'AdminFeedback::index');
$routes->get('admin/feedback/sembunyikan/(:num)', 'AdminFeedback::sembunyikan/$1');
$routes->get('admin/feedback/tampilkan/(:num)', 'AdminFeedback::tampilkan/$1');
$routes->get('admin/feedback/hapus/(:num)', 'AdminFeedback::hapus/$1');
$routes->post('home/kirim_feedback', 'Feedback::simpanUmum');

// ===================== REST API (JSON) =====================
$routes->group('api', static function ($routes) {
    // rute khusus harus ditulis SEBELUM resource, supaya "geojson" tidak dianggap sebagai {id}
    $routes->get('spbu/geojson', 'Api\Spbu::geojson');

    // GET /api/spbu, GET /api/spbu/{id}, POST /api/spbu, PUT /api/spbu/{id}, DELETE /api/spbu/{id}
    $routes->resource('spbu', [
        'controller' => 'Api\Spbu',
        'only'       => ['index', 'show', 'create', 'update', 'delete'],
    ]);

    // data referensi (hanya GET)
    $routes->get('jenis',         'Api\Referensi::jenis');
    $routes->get('provinsi',      'Api\Referensi::provinsi');
    $routes->get('kabupaten',     'Api\Referensi::kabupaten');
    $routes->get('kecamatan',     'Api\Referensi::kecamatan');
    $routes->get('wilayah',       'Api\Referensi::wilayah');
    $routes->get('wilayah/(:num)', 'Api\Referensi::wilayahDetail/$1');
});
