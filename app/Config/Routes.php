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
$routes->get('/admin/wilayah', 'Wilayah::index');
$routes->get('/wilayah/input', 'Wilayah::Add');
$routes->post('/wilayah/simpan', 'Wilayah::InsertData');