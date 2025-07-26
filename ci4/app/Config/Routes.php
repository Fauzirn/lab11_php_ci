<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home'); // Controller default jika tidak ada URI
$routes->setDefaultMethod('index');    // Method default jika tidak ada method di URI
$routes->setTranslateURIDashes(false); // Apakah tanda '-' di URI diterjemahkan menjadi '_'
$routes->set404Override();             // Override halaman 404 (bisa diisi controller/method khusus)
$routes->setAutoRoute(false);           // Mengaktifkan auto routing (boleh diaktifkan atau dimatikan)

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Route untuk halaman utama
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');

// Route untuk artikel publik
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

// Route untuk kategori
$routes->get('/kategori/(:segment)', 'Artikel::kategori/$1');

// Routes untuk AJAX
$routes->get('artikel', 'Artikel::index');
$routes->get('artikel/ajaxList', 'Artikel::ajaxList');
$routes->get('/ajax', 'AjaxController::index');
$routes->get('/ajax/getData', 'AjaxController::getData');
$routes->get('/ajax/getById/(:num)', 'AjaxController::getById/$1');
$routes->post('/ajax/save', 'AjaxController::save');
$routes->delete('/ajax/delete/(:num)', 'AjaxController::delete/$1');

// Route untuk user
$routes->match(['get', 'post'], 'user/register', 'User::register');
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');


// Route untuk admin dengan filter auth
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'User::dashboard');
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/add', 'Artikel::add');
    $routes->get('artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->post('artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');
});

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
// Route untuk API

//$routes->get('/tos', 'Pages::tos');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * Jika Anda ingin menambahkan routing khusus per environment (development, production dll)
 * Anda bisa membuat file Routes.php di dalam folder Config sesuai environment.
 */
//if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
//    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
//}

