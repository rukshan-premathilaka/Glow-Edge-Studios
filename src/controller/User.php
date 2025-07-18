<?php

namespace controller;

use core\DBHandle;
use Respect\Validation\Validator as v;

class User
{
    public function create():string
    {
        $name = $this->input('name');
        $email = $this->input('email');
        $password = $this->input('password');
        $re_password = $this->input('re_password');

        // Form validation
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
            return 'Re-entered password does not match!';
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
            return 'Email already in use!';
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

        return 'success';
    }

    public function login(): string
    {
        $email = $this->input('email');
        $password = $this->input('password');

        // Form validation
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
        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];


        return 'success';
    }

    public function logout(): string
    {
        // Destroy  session
        session_unset();
        session_destroy();

        return 'success';
    }

    public function delete(): string
    {
        $password = $this->input('password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($password)) {
            http_response_code(422);
            return 'Password is required!';
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user_id']]);

        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return 'Invalid password!';
        }

        // Delete user
        $result = DBHandle::query("DELETE FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user_id']]);
        if (!$result) {
            http_response_code(500);
            return 'Database error!';
        }

        // Destroy  session
        session_unset();
        session_destroy();

        return 'success';
    }

    public function setPassword(): string
    {
        $password = $this->input('password');
        $new_password = $this->input('new_password');
        $re_new_password = $this->input('re_new_password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($password)) {
            http_response_code(422);
            return 'Password is required!';
        }
        if (!v::stringType()->notEmpty()->validate($new_password)) {
            http_response_code(422);
            return 'New password is required!';
        }
        if (!v::stringType()->notEmpty()->validate($re_new_password)) {
            http_response_code(422);
            return 'Re-entered password is required!';
        }
        // Database validation
        if (!v::stringType()->length(1, 20)->validate($new_password)) {
            http_response_code(422);
            return 'Password is too long! (20 characters max)';
        }
        if ($new_password !== $re_new_password) {
            http_response_code(422);
            return 'Re-entered password does not match!';
        }
        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user_id']]);

        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return 'Invalid current password!';
        }

        // Update password
        $result = DBHandle::query("UPDATE user SET password = :password WHERE user_id = :user_id", ['password' => password_hash($new_password, PASSWORD_DEFAULT), 'user_id' => $_SESSION['user_id']]);
        if (!$result) {
            http_response_code(500);
            return 'Database error!';
        }

        // Destroy  session
        unset($_SESSION['user_id']);

        return 'success';
    }

    /* Helper Methods */
    private function input(string $key): string {
        return isset($_POST[$key]) ? trim($_POST[$key]) : '';
    }


}