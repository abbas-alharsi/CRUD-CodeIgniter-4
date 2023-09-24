<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MyController::myView');
$routes->post('/insert-data','MyController::insertData');
$routes->get('/getdata/(:any)','MyController::getData/$1');
$routes->get('/getdata','MyController::getData');
$routes->post('/delete','MyController::deleteData');
$routes->post('/update','MyController::updateData');