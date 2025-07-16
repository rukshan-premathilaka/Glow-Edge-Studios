<?php

namespace controller;

use core\DBHandle;
use csrf\CsrfToken;
use Respect\Validation\Validator as v;

class User extends CsrfToken
{
    public function create():string
    {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $re_password = isset($_POST['re_password']) ? trim($_POST['re_password']) : '';

        // Form validation
        if (!isset($_POST[$this->tokenName]) || !$this->validateCSRF($_POST[$this->tokenName])) {
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
        if (!v::stringType()->length(1, 255)->validate($name)) {
            http_response_code(422);
            return 'Name is too long! (255 characters max)';
        }
        if (!v::stringType()->length(1, 255)->validate($email)) {
            http_response_code(422);
            return 'Email is too long! (255 characters max)';
        }
        if (!v::stringType()->length(1, 20)->validate($password)) {
            http_response_code(422);
            return 'Password is too long! (20 characters max)';
        }

        // Check if email already exists
        $existing = DBHandle::query("SELECT `user_id` FROM user WHERE email = :email", ['email' => $email]);
        if (!empty($existing)) {
            http_response_code(409); // Conflict
            return 'Email already in use! Please Login or use another email.';
        }


        // Create new user
        $result = DBHandle::query("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)", [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        if (!$result) {
            http_response_code(500);
            return 'Database error!';
        }

        $this->clearCSRF();

        return 'success';
    }

    public function authorize(): string
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Form validation
        if (!isset($_POST[$this->tokenName]) || !$this->validateCSRF($_POST[$this->tokenName])) {
            http_response_code(403);
            return 'Unauthorized!';
        }
        if (!v::email()->validate($email)) {
            http_response_code(422);
            return 'Email is required!';
        }
        if (!v::stringType()->notEmpty()->validate($password)) {
            http_response_code(422);
            return 'Password is required!';
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE email = :email", ['email' => $email]);
        // Check if user exists
        if (empty($user)) {
            http_response_code(401);
            return 'Invalid email or password!';
        }
        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return 'Invalid email or password!';
        }

        // Set session
        $_SESSION['user_id'] = $user['user_id'];
        $this->clearCSRF();


        return 'success';
    }
}