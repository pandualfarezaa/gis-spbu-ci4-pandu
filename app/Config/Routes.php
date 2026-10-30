<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// ===================== PUBLIK / FRONT-END =====================
$routes->get('/',    'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home/wilayah/(:num)', 'Home::wilayah/$1');
$routes->get('home/jenis/(:num)',   'Home::jenis/$1');
$routes->get('home/detail/(:num)',  'Home::detail/$1');

// ===================== AUTH =====================
$routes->get('auth/login',      'Auth::login');
$routes->post('auth/cek_login', 'Auth::cek_login');
$routes->get('auth/logout',     'Auth::logout');
$routes->get('auth/register',   'Auth::register');
$routes->post('auth/simpan_register', 'Auth::simpan_register');

// ===================== ADMIN =====================
$routes->get('admin',           'Admin::index');
$routes->get('admin/dashboard', 'Admin::index');
$routes->get('admin/setting',   'Admin::setting');
$routes->post('admin/update-setting', 'Admin::UpdateSetting');

// --- Wilayah ---
$routes->get('admin/wilayah',                       'Wilayah::index');
$routes->get('admin/wilayah/input',                 'Wilayah::Input');
$routes->post('admin/wilayah/simpan',               'Wilayah::InsertData');
$routes->get('admin/wilayah/edit/(:num)',            'Wilayah::Edit/$1');
$routes->post('admin/wilayah/updatedata/(:num)',     'Wilayah::UpdateData/$1');
$routes->get('admin/wilayah/delete/(:num)',          'Wilayah::delete/$1');

// --- SPBU ---
$routes->get('admin/spbu',                          'SPBU::index');
$routes->get('admin/spbu/input',                    'SPBU::Input');
$routes->post('admin/spbu/insertdata',              'SPBU::InsertData');
$routes->get('admin/spbu/edit/(:num)',               'SPBU::Edit/$1');
$routes->post('admin/spbu/updatedata/(:num)',        'SPBU::UpdateData/$1');
$routes->get('admin/spbu/delete/(:num)',             'SPBU::Delete/$1');
$routes->post('admin/spbu/kabupaten',               'SPBU::Kabupaten');
$routes->post('admin/spbu/kecamatan',               'SPBU::Kecamatan');
$routes->get('admin/spbu/detail/(:num)',             'SPBU::Detail/$1');

// --- Jenis SPBU ---
$routes->get('admin/jenis',                                'JenisSPBU::index');
$routes->get('admin/jenis_spbu',                           'JenisSPBU::index');
$routes->post('admin/jenis_spbu/updatedata/(:num)',        'JenisSPBU::UpdateData/$1');

// --- User ---
$routes->get('admin/user',                          'User::index');
$routes->get('admin/user/input',                    'User::Input');
$routes->post('admin/user/insertdata',              'User::InsertData');
$routes->get('admin/user/edit/(:num)',               'User::Edit/$1');
$routes->post('admin/user/updatedata/(:num)',        'User::UpdateData/$1');
$routes->get('admin/user/delete/(:num)',             'User::Hapus/$1');
$routes->get('admin/user/hapus/(:num)',              'User::Hapus/$1');

// ===================== REST API (JSON) =====================
$routes->group('api', static function ($routes) {
    $routes->get('spbu/geojson', 'Api\Spbu::geojson');

    $routes->resource('spbu', [
        'controller' => 'Api\Spbu',
        'only'       => ['index', 'show', 'create', 'update', 'delete'],
    ]);

    $routes->get('jenis',          'Api\Referensi::jenis');
    $routes->get('provinsi',       'Api\Referensi::provinsi');
    $routes->get('kabupaten',      'Api\Referensi::kabupaten');
    $routes->get('kecamatan',      'Api\Referensi::kecamatan');
    $routes->get('wilayah',        'Api\Referensi::wilayah');
    $routes->get('wilayah/(:num)', 'Api\Referensi::wilayahDetail/$1');
});
