<?php

namespace controller;

require 'vendor/autoload.php';

use csrf\CsrfToken;

class User extends CsrfToken
{
    public function create():string
    {
        if (empty($_POST['name'])) {
            http_response_code(422);
            return 'Name is required!';
        }
        if (empty($_POST['email'])) {
            http_response_code(422);
            return 'Email is required!';
        }
        if (empty($_POST['password'])) {
            http_response_code(422);
            return 'Password is required!';
        }
        if (empty($_POST['re_password']) || $_POST['password'] !== $_POST['re_password']) {
            http_response_code(422);
            return 'Re Enter Password is required! or Does\'t match';
        }

        return '';
    }

    public function login(): string
    {
        if (!isset($_POST[$this->tokenName]) || !$this->validate($_POST[$this->tokenName])) {
            http_response_code(403);
            return 'Unauthorized!';
        }
        if (!isset($_POST['name']) || !empty($_POST['name'])) {
            http_response_code(422);
            return 'Name is required!';
        }
        if (!isset($_POST['email']) || !empty($_POST['email'])) {
            http_response_code(422);
            return 'email is required!';
        }

        return '';
    }
}