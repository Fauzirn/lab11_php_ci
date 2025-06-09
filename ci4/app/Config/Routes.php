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
$routes->setAutoRoute(true);           // Mengaktifkan auto routing (boleh diaktifkan atau dimatikan)

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Route default, biasanya mengarah ke Home controller
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/artikel', 'Page::artikel');
$routes->get('/contact', 'Page::kontak');
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

