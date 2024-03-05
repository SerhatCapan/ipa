<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

/**
 * Costcenter
 */
$routes->post('/costcenter/create', 'Costcenter::create');
$routes->post('/costcenter/update', 'Costcenter::update');
$routes->get('/costcenter/read', 'Costcenter::read');
$routes->post('/costcenter/delete', 'Costcenter::delete');


/**
 * User
 */
$routes->post('/user/create', 'User::create');
$routes->post('/user/delete', 'User::delete');


