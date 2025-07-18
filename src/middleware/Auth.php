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

    public function isAdmin(): void
    {
        $this->handle();

        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /404');
            exit;
        }
    }
}