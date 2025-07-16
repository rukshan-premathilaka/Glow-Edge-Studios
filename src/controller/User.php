<?php

namespace controller;

use csrf\CsrfToken;
use Respect\Validation\Validator as v;

class User extends CsrfToken
{
    public function create():string
    {
        $name = trim($_POST['name']) ?? '';
        $email = trim($_POST['email']) ?? '';
        $password = trim($_POST['password']) ?? '';
        $re_password = trim($_POST['re_password']) ?? '';

        // Form validation
        if (!isset($_POST[$this->tokenName]) || !$this->validate($_POST[$this->tokenName])) {
            http_response_code(403);
            return 'Unauthorized!';
        }
        if (!v::stringType()->notEmpty()->validate($name)) {
            http_response_code(422);
            return 'Name is required!';
        }
        if (!v::email()->validate($email)) {
            http_response_code(422);
            return 'Email is required!';
        }
        if (!v::stringType()->notEmpty()->validate($password)) {
            http_response_code(422);
            return 'Password is required!';
        }
        if ($password !== $re_password) {
            http_response_code(422);
            return 'Re-entered password is does not match!';
        }

        // Database validation
        if (!v::max(255)->validate($name)) {
            http_response_code(422);
            return 'Name is too long! (255 characters max)';
        }
        if (!v::max(255)->validate($email)) {
            http_response_code(422);
            return 'Email is too long! (255 characters max)';
        }
        if (!v::max(20)->validate($password)) {
            http_response_code(422);
            return 'Password is too long! (255 characters max)';
        }



        return 'success';
    }

    public function login(): string
    {

        return '';
    }
}