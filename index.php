<?php

require 'vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use controller\User;

// Session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$router = new RouteCollector();

/* --- TEST --- */
$router->get('/home', function () {
    require 'views/home.php';
});
$router->get('/t', function () {
    require 'test/test.php';
});

/* --- USER ROUTE GROUP --- */
$router->group(['prefix' => 'user'], function (RouteCollector $r) {
    $r->get('/signup', function () {
        require 'views/user/signup.php';
    });
    $r->get('/login', function () {
        require 'views/user/signing.php';
    });

    $r->post('/signup',  [User::class, 'create']);
    $r->Post('/signing',  [User::class, 'login']);
});






// Dispatcher
$dispatcher = new Dispatcher($router->getData());

// Current URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    // Try to dispatch the request
    echo $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);

} catch (HttpRouteNotFoundException $e) {
    // 404 Not Found
    http_response_code(404);
    require_once 'views/404.php';
}