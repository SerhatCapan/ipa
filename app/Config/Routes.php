<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/home', 'Dashboard::index');

/**
 * Costcenter
 */
$routes->get('/costcenter', 'Costcenter::index');
$routes->get('/costcenter/(:any)', 'Costcenter::index');
$routes->post('/costcenter/create', 'Costcenter::create');
$routes->post('/costcenter/update', 'Costcenter::update');
$routes->get('/costcenter/read', 'Costcenter::read');
$routes->post('/costcenter/delete', 'Costcenter::delete');


/**
 * User
 */
$routes->post('/user/create', 'User::create');
$routes->post('/user/delete', 'User::delete');


