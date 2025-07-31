<?php

namespace controller;

use Controller\Helper;
use Controller\Portfolio;

class AdminView extends Helper
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


}