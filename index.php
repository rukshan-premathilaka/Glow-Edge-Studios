<?php

require 'vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
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
$router->get('/ct', function () {
    require 'views/user/test.php';
});

/* --- EMAIL VERIFICATION TEST --- */
$router->get('/mail', function () {
    $token = new csrf\CsrfToken();
    $mail = new service\Mail('Rukshan', 'ruka6486@gmail.com', 1, $token->generateCSRF(60));
    $mail->sendMail();
});

$router->get('/user/verify', function () {
    $key = $_GET['key'] ?? '';
    $id = $_GET['id'] ?? '';
    $email = $_GET['email'] ?? '';

    // You should validate token and ID here
    if (!empty($key) && !empty($id) && !empty($email)) {
        // Example: check token and mark email as verified in DB
        return "Email verified for user ID $id with email $email and token $key";
    }

    http_response_code(400);
    return "Invalid verification link!";
});


/* --- CSRF TOKEN --- */
$router->get('/csrf', function () {
    return (new csrf\CsrfToken())->getTokenScriptTag();
});

/* --- USER ROUTE GROUP --- */
$router->group(['prefix' => 'user'], function (RouteCollector $r) {
    $r->get('/signup', function () {
        require 'views/user/signup.php';
    });
    $r->get('/signing', function () {
        require 'views/user/signing.php';
    });
    $r->get('/change_password', function () {
        require 'views/user/change_password.php';
    });
    $r->post('/signup',  [User::class, 'create']);
    $r->Post('/login',  [User::class, 'login']);
    $r->post('/logout', [User::class, 'logout']);
    $r->post('/delete', [User::class, 'delete']);
    $r->post('/change_password',  [User::class, 'setPassword']);
});






// Dispatcher
$dispatcher = new Dispatcher($router->getData());

// Current URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    // Try to dispatch the request
    echo $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);

} catch (Exception $e) {
    // 404 Not Found
    http_response_code(404);
    require_once 'views/404.php';
}