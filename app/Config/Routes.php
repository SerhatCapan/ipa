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
$routes->get('/costcenter', 'CostCenter::index');
$routes->get('/costcenter/(:any)', 'CostCenter::index');
$routes->post('/costcenter/create', 'CostCenter::create');
$routes->post('/costcenter/update', 'CostCenter::update');
$routes->post('/costcenter/read', 'CostCenter::read');
$routes->post('/costcenter/delete', 'CostCenter::delete');

/**
 * Costcenter Group
 */
$routes->get('/costcenter-group', 'CostcenterGroup::index');
$routes->get('/costcenter-group/(:any)', 'CostcenterGroup::index');
$routes->post('/costcenter-group/create', 'CostcenterGroup::create');
$routes->post('/costcenter-group/update', 'CostcenterGroup::update');
$routes->post('/costcenter-group/read', 'CostcenterGroup::read');
$routes->post('/costcenter-group/delete', 'CostcenterGroup::delete');

/**
 * User
 * - Vacation
 * - Vacation Credit
 */
$routes->get('/user', 'User::index');
$routes->post('/user/create', 'User::create');
$routes->post('/user/update', 'User::update');
$routes->post('/user/delete', 'User::delete');
$routes->post('/user/switch', 'User::switch');

$routes->get('/user/vacation/', 'Vacation::index');
$routes->post('/user/vacation/create', 'Vacation::create');
$routes->get('/user/vacation/read', 'Vacation::read');
$routes->post('/user/vacation/update', 'Vacation::update');
$routes->post('/user/vacation/delete', 'Vacation::delete');

$routes->get('/user/vacation-credit/', 'VacationCredit::index');
$routes->post('/user/vacation-credit/create', 'VacationCredit::create');
$routes->get('/user/vacation-credit/read', 'VacationCredit::read');
$routes->post('/user/vacation-credit/update', 'VacationCredit::update');
$routes->post('/user/vacation-credit/delete', 'VacationCredit::delete');

$routes->get('/user/absence/', 'Absence::index');
$routes->post('/user/absence/create', 'Absence::create');
$routes->get('/user/absence/read', 'Absence::read');
$routes->post('/user/absence/update', 'Absence::update');
$routes->post('/user/absence/delete', 'Absence::delete');

/**
 * Holiday
 */
$routes->get('/holiday', 'Holiday::index');
$routes->post('/holiday/create', 'Holiday::create');
$routes->post('/holiday/update', 'Holiday::update');
$routes->post('/holiday/read', 'Holiday::read');
$routes->post('/holiday/delete', 'Holiday::delete');

/**
 * Settings
 */
$routes->get('/settings', 'Settings::index');
$routes->post('/settings/update', 'Settings::update');


