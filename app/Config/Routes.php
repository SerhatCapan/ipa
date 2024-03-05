<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

/**
 * User
 */
$routes->post('/user/create', 'User::create');
$routes->post('/user/delete', 'User::delete');
