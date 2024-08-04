<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/profil', 'ProfilController::index');
$routes->post('/profil', 'ProfilController::update');

$routes->get('/dashboard', 'DashboardController::index');

$routes->get('/user', 'UserController::index');
$routes->get('/user/create', 'UserController::create');
$routes->post('/user/store', 'UserController::store');
$routes->get('/user/edit/(:num)', 'UserController::edit/$1');
$routes->post('/user/update/(:num)', 'UserController::update/$1');
$routes->post('/user/delete/(:num)', 'UserController::delete/$1');

$routes->get('/kamar', 'KamarController::index');
$routes->get('/kamar/create', 'KamarController::create');
$routes->post('/kamar/store', 'KamarController::store');
$routes->get('/kamar/edit/(:num)', 'KamarController::edit/$1');
$routes->post('/kamar/update/(:num)', 'KamarController::update/$1');
$routes->post('/kamar/delete/(:num)', 'KamarController::delete/$1');

$routes->get('/reservasi', 'ReservasiController::index');
$routes->get('/reservasi/create', 'ReservasiController::create');
$routes->post('/reservasi/store', 'ReservasiController::store');
$routes->get('/reservasi/edit/(:num)', 'ReservasiController::edit/$1');
$routes->post('/reservasi/update/(:num)', 'ReservasiController::update/$1');
$routes->post('/reservasi/delete/(:num)', 'ReservasiController::delete/$1');
$routes->get('/kamar/pesan/(:num)', 'ReservasiController::createKamar/$1');
$routes->post('/kamar/pesan/(:num)', 'ReservasiController::storeKamar/$1');
$routes->post('reservasi/detail', 'ReservasiController::detail');
