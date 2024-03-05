<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/**
 * Costcenter
 */
$routes->get('/costcenter/create', 'Costcenter::create');
$routes->get('/costcenter/read', 'Costcenter::read');
$routes->get('/costcenter/update', 'Costcenter::update');
$routes->get('/costcenter/delete', 'Costcenter::delete');