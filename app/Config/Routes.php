<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/coba', function () {
    echo 'Hello World';
});
$routes->get('/coba/(:any)', 'Home::about/$1');
$routes->get('/coba/(:any)/(:num)', 'Home::about/$1/$2');
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
$routes->get('coba2/(:uuid)', function ($uuid) {
    echo "UUID: $uuid";
});
// $routes->group('adm', function ($r) {
//     $r->get('users', 'Admin\User::index');
//     $r->get('master', 'Admin\Master::index');
// });
$routes->get(
    '/index',
    'Home::index'
);
$routes->post('/chart-transaksi', 'Home::showChartTransaksi');
$routes->post('/chart-customer', 'Home::showChartCustomer');
$routes->post('/chart-pembelian', 'Home::showChartPembelian');
$routes->post('/chart-supplier', 'Home::showChartSupplier');
$routes->get(
    '/index2',
    'Home::container1'
);

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/book', 'Book::index');
$routes->get('/book/create', 'Book::create');
$routes->post('/book/create', 'Book::save');
$routes->post('/book/edit/(:any)', 'Book::update/$1');
$routes->get('/book/edit/(:any)', 'Book::edit/$1');
$routes->delete('/book/delete/(:num)', 'Book::delete/$1');
$routes->get('/book/(:any)', 'Book::detail/$1');
$routes->post('/book/import', 'Book::importData');

$routes->get('/komik', 'Komik::index', ['filter' => 'auth']);
$routes->get('/komik/create', 'Komik::create');
$routes->post('/komik/create', 'Komik::save');
$routes->post('/komik/edit/(:any)', 'Komik::update/$1');
$routes->get('/komik/edit/(:any)', 'Komik::edit/$1');
$routes->get('/komik-detail/(:any)', 'Komik::detail/$1');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
$routes->post('/komik/import', 'Komik::importData');

$routes->addRedirect('/customer', 'customer/index')->get('/customer/index', 'Customer::index')->setAutoRoute(true);
$routes->addRedirect('/supplier', 'supplier/index')->get('/supplier/index', 'Supplier::index')->setAutoRoute(true);


$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/page', 'Home::page');


$routes->get('/login', 'Auth::indexlogin');
$routes->post('/login/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/login/register', 'Auth::indexregister');
$routes->post('/login/save', 'Auth::saveRegister');


$routes->group('users', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Users::index');
    $r->get('index', 'Users::index');
    $r->get('create', 'Users::create');
    $r->post('create', 'Users::save');
    $r->get('edit/(:num)', 'Users::edit/$1');
    $r->post('edit/(:num)', 'Users::update/$1');
    $r->delete('delete/(:num)', 'Users::delete/$1');
});

$routes->group('jual', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Penjualan::index');
    $r->get('load', 'Penjualan::loadCart');
    $r->post('/', 'Penjualan::addCart');
    $r->get('gettotal', 'Penjualan::getTotal');
    $r->post('update', 'Penjualan::updateCart');
    $r->post('bayar', 'Penjualan::pembayaran');
    $r->delete('(:any)', 'Penjualan::deleteCart/$1');
    $r->get('laporan', 'Penjualan::report');
    $r->post('laporan/filter', 'Penjualan::filter');
    $r->get('exportpdf', 'Penjualan::exportPDF');
    $r->get('exportexcel', 'Penjualan::exportExcel');
});

$routes->group('beli', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Pembelian::index');
    $r->get('load', 'Pembelian::loadCart');
    $r->post('/', 'Pembelian::addCart');
    $r->get('gettotal', 'Pembelian::getTotal');
    $r->post('update', 'Pembelian::updateCart');
    $r->post('bayar', 'Pembelian::pembayaran');
    $r->delete('(:any)', 'Pembelian::deleteCart/$1');
    $r->get('laporan', 'pembelian::report');
    $r->post('laporan/filter', 'pembelian::filter');
    $r->get('exportpdf', 'pembelian::exportPDF');
    $r->get('exportexcel', 'pembelian::exportExcel');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
