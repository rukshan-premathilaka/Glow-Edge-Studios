<?php

require 'vendor/autoload.php';

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use controller\User;
use controller\Admin;
use middleware\CsrfToken;
use middleware\Auth;
use Dotenv\Dotenv;


/* --- LOAD ENV --- */
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    die('Error loading .env file: ' . $e->getMessage());
}


$router = new RouteCollector();





/* --- MIDDLEWARE --- */
$router->filter('auth', [Auth::class, 'handle']);
$router->filter('authAdmin', [Auth::class, 'isAdmin']);
$router->filter('csrf', [CsrfToken::class, 'validate']);


/* --- CSRF TOKEN --- */
$router->get('/csrf', function () {
    return (new middleware\CsrfToken())->getScriptTag();
});

/* --- PAGE --- */
$router->get('/', function () {
    require 'views/home.php';
});
$router->get('/home', function () {
    require 'views/home.php';
});


/*  --- FORGOT PASSWORD --- */
$router->get('/forgot_password', function () {
    require 'views/user/forgot_password.php';
});
$router->get('/new_password',  [User::class, 'getNewPasswordPage']);
$router->group(['before' => 'csrf'], function (RouteCollector $r) {
    $r->post('/forgot_password',  [User::class, 'forgotPassword']);  // send email
    $r->post('/new_password',  [User::class, 'setNewPassword']); // add new password
});

/* --- USER ROUTE GROUP --- */
$router->group(['prefix' => 'user'], function (RouteCollector $r) {
    $r->get('/signup', function () {
        require 'views/user/signup.php';
    });
    $r->get('/login', function () {
        require 'views/user/login.php';
    });
    $r->group(['before' => 'csrf'], function (RouteCollector $r) {
        $r->post('/signup',  [User::class, 'create']);
        $r->Post('/login',  [User::class, 'login']);
        $r->group(['before' => 'auth'], function (RouteCollector $r) {
            $r->post('/logout', [User::class, 'logout']);
            $r->post('/delete', [User::class, 'delete']);
            $r->get('/change_password', function () {
                require 'views/user/change_password.php';
            });
            $r->post('/change_password',  [User::class, 'setPassword']);
        });
    });
});

/* --- ADMIN ROUTE GROUP --- */
$router->group(['prefix' => 'admin', 'before' => 'authAdmin'], function (RouteCollector $r) {
    $r->get('/dashboard', function () {
        require 'views/admin/dashboard.php';
    });
    /* --- PORTFOLIO --- */
    $r->group(['prefix' => 'portfolio'], function (RouteCollector $r) {
        $r->post('/add', [Admin::class, 'addPortfolioItem']);
    });

});





// Dispatcher
$dispatcher = new Dispatcher($router->getData());

// Current URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// print uri

try {
    // Try to dispatch the request
    echo $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);
} catch (Exception $e) {
    // 404 Not Found
    http_response_code(404);
    require_once 'views/404.php';
}
