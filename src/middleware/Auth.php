<?php

namespace middleware;

class Auth
{
    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }
    }
}