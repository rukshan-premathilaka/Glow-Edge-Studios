<?php

namespace middleware;

class Auth
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }
    }

    public function isAdmin(): void
    {
        $this->handle();

        if (!isset($_SESSION['user']['role']) || !in_array('admin', $_SESSION['user']['role'], true)) {
            $_SESSION['error'] = 'You do not have permission to access this page.';
            header('Location: /404');
            exit;
        }
    }


}