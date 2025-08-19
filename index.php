<?php

require 'vendor/autoload.php';

use controller\Booking;
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

/* --- USER ROUTE GROUP --- */
$router->group(['prefix' => 'user'], function (RouteCollector $r) {
    $r->get('/signup', function () {
        require 'views/user/signup.php';
    }); // give signup page
    $r->get('/login', function () {
        require 'views/user/login.php';
    }); // give login page
    $r->get('/forgot_password', function () {
        require 'views/user/forgot_password.php';
    });   // give forgot password page
    $r->get('/new_password',  [User::class, 'getNewPasswordPage']);  // give new password page from email
    $r->group(['before' => 'csrf'], function (RouteCollector $r) {
        $r->post('/signup',  [User::class, 'create']); // create new user account
        $r->Post('/login',  [User::class, 'login']); // login
        $r->post('/forgot_password',  [User::class, 'forgotPassword']);  // send email
        $r->post('/new_password',  [User::class, 'setNewPassword']); // add new password
        $r->group(['before' => 'auth'], function (RouteCollector $r) {
            $r->post('/logout', [User::class, 'logout']); // logout
            $r->post('/delete', [User::class, 'delete']); // delete user
            $r->get('/change_password', function () {
                require 'views/user/change_password.php';
            }); // give change password page
            $r->post('/change_password',  [User::class, 'setPassword']); // change password
            $r->post('/update',  [User::class, 'update']); // update user
            $r->post('/booking_details', [Booking::class, 'getDetails']);
        });
    });
    $r->group(['before' => 'auth'], function (RouteCollector $r) {
        $r->get('/profile_settings', function () {
            require 'views/user/profile_setting.php';
        }); // give profile setting page
        $r->get('/my_booking', function () {
            require 'views/user/my_booking.php';
        }); // give my booking page
    });
});

/* --- ADMIN ROUTE GROUP --- */
$router->group(['prefix' => 'admin', 'before' => 'authAdmin'], callback: function (RouteCollector $r) {
    $r->get('/dashboard', function () {
        require 'views/admin/dashboard.php';
    });
    $r->get('/bookings', function () {
        require 'views/admin/bookings.php';
    });
    $r->get('/services', function () {
        require 'views/admin/servicers.php';
    });
    $r->get('/portfolio', function () {
        require 'views/admin/portfolio.php';
    });
    $r->get('/add_portfolio', function () {
        require 'views/admin/add-portfolio.php';
    });
    $r->get('/add_service', function () {
        require 'views/admin/add-servicers.php';
    });
    $r->get('/booking-details', function () {
        require 'views/admin/Booking-details.php';
    });


    $r->group(['before' => 'csrf'], function (RouteCollector $r) {
        /* --- PORTFOLIO --- */
        $r->group(['prefix' => 'portfolio'], function (RouteCollector $r) {
            $r->post('/add', [Admin::class, 'addPortfolioItem']);
            $r->post('/update', [Admin::class, 'updatePortfolioItem']);
            $r->post('/delete', [Admin::class, 'deletePortfolioItem']);
        });
        /*  --- BOOKINGS --- */
        $r->group(['prefix' => 'booking'], function (RouteCollector $r) {
            $r->post('/all', [Booking::class, 'getAll']);
            $r->post('/confirm', [Booking::class, 'confirm']);
            $r->post('/delete', [Booking::class, 'delete']);
            $r->post('/cancel', [Booking::class, 'cancel']);
        });
        /*  --- SERVICES --- */
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
