<?php
require_once ROUTING_PATH . '/Router.php';
require_once CONTROLLER_PATH . '/DashboardController.php';
require_once CONTROLLER_PATH . '/ClientController.php';


$router = new Router();

// Define your routes
$router->add('GET', '/', 'DashboardController@index');
$router->add('GET', '/login', 'DashboardController@login');
$router->add('GET', '/clients/add', 'ClientController@create');
$router->add('GET', '/clients', 'ClientController@index');


// Dispatch the request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$router->dispatch($requestUri, $requestMethod);
