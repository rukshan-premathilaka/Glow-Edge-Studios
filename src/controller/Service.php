<?php

namespace controller;

use core\DBHandle;

class Service extends Helper
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add(): string
    {
        return $this->jsonResponse("success", "Service added!");
    }

    public function update(): string
    {
        return $this->jsonResponse("success", "Service updated!");
    }

    public function delete(): string
    {
        return $this->jsonResponse("success", "Service deleted!");
    }

    public static function count(): string
    {
        $count = DBHandle::query('SELECT COUNT(*) as services_count FROM services');
        return (string) $count[0]['services_count'];
    }

}