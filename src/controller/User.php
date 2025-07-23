<?php

namespace controller;

use core\DBHandle;
use middleware\CsrfToken;
use Respect\Validation\Validator as v;
use service\Mail;

class User extends Helper
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function create():string
    {
        $name = $this->PostInput('name');
        $email = $this->PostInput('email');
        $password = $this->PostInput('password');
        $re_password = $this->PostInput('re_password');

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

        // Get user id
        $user_id = (DBHandle::query("SELECT `user_id` FROM user WHERE email = :email", ['email' => $email]));
        if (!$user_id) {
            http_response_code(500);
            return 'Database error!';
        }
        $user_id = $user_id[0]['user_id'];

        // Get role id
        $role_id = (DBHandle::query("SELECT `role_id` FROM role WHERE role = :role", ['role' => 'user']));
        if (!$role_id) {
            http_response_code(500);
            return 'Database error!';
        }
        $role_id = $role_id[0]['role_id'];

        // Create user role
        $result = DBHandle::query("INSERT INTO user_has_role (user_user_id, role_role_id) VALUES (:user_id, :role_id)",
            [
                'user_id' => $user_id,
                'role_id' => $role_id
            ]);
        if (!$result) {
            http_response_code(500);
            return 'Database error!';
        }

        CsrfToken::clearCSRFToken();

        return 'success';
    }

    public function login(): string
    {
        $email = $this->PostInput('email');
        $password = $this->PostInput('password');

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

        // Set user role
        $sql = "SELECT
                    r.role
                FROM
                    user_has_role uhr
                    INNER JOIN role r ON uhr.role_role_id = r.role_id
                    INNER JOIN user u ON uhr.user_user_id = u.user_id
                WHERE u.user_id = :userId;";

        $result = DBHandle::query($sql, [
            'userId' => $user['user_id']
        ]);

        // Set user roles
        foreach ($result as $role) {
            $_SESSION['user']['role'][] = $role['role'];
        }


        CsrfToken::clearCSRFToken();

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
        $password = $this->PostInput('password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($password)) {
            http_response_code(422);
            return 'Password is required!';
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);

        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return 'Invalid password!';
        }

        // Delete user
        $result = DBHandle::query("DELETE FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);
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
        $password = $this->PostInput('password');
        $new_password = $this->PostInput('new_password');
        $re_new_password = $this->PostInput('re_new_password');

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
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);

        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return 'Invalid current password!';
        }

        // Update password
        $result = DBHandle::query("UPDATE user SET password = :password WHERE user_id = :user_id", ['password' => password_hash($new_password, PASSWORD_DEFAULT), 'user_id' => $_SESSION['user']['user_id']]);
        if (!$result) {
            http_response_code(500);
            return 'Database error!';
        }

        // Destroy  session
        unset($_SESSION['user']);

        CsrfToken::clearCSRFToken();
        return 'success';
    }

    public function forgotPassword(): string
    {
        $email = $this->PostInput('email');

        // Form validation
        if (!v::email()->validate($email)) {
            http_response_code(422);
            return 'Email is required!';
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE email = :email", ['email' => $email]);

        // Check email exists
        $user = $user[0];
        if (!$user) {
            http_response_code(401);
            return 'Email not found!';
        }

        // Send email
        CsrfToken::clearCSRFToken();
        $mail = new Mail($user['name'], $user['email'], $user['user_id'], (new CsrfToken())->generate(60 * 3));
        $mail->setContentResetPassword();
        $mail->sendMail();



        return 'success';
    }

    public function getNewPasswordPage() : void
    {
        $token = $this->PostInput('key');
        $id = $this->getInput('id');
        $email = $this->PostInput('email');

        // validate token
        $csrf = new CsrfToken();
        $csrf->validate($token);
        $csrf->clear();

        // Give set new password page
        require 'views/user/create_new_password.php';
    }



}