<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/home', 'Dashboard::index');

/**
 * Workday
 */
$routes->post('/workday/create', 'Workday::create');

/**
 * Workhour
 */
$routes->post('/workhour/create', 'Workhour::create');
$routes->post('/workhour/update', 'Workhour::update');
$routes->post('/workhour/delete', 'Workhour::delete');

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
 * Costcenter Group
 */
$routes->get('/costcenter-group', 'CostcenterGroup::index');
$routes->get('/costcenter-group/(:any)', 'CostcenterGroup::index');
$routes->post('/costcenter-group/create', 'CostcenterGroup::create');
$routes->post('/costcenter-group/update', 'CostcenterGroup::update');
$routes->get('/costcenter-group/read', 'CostcenterGroup::read');
$routes->post('/costcenter-group/delete', 'CostcenterGroup::delete');

/**
 * User
 */
$routes->get('/user', 'User::index');
$routes->post('/user/create', 'User::create');
$routes->post('/user/update', 'User::update');
$routes->post('/user/delete', 'User::delete');
$routes->post('/user/switch', 'User::switch');


