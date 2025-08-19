<?php

namespace controller;

use core\DBHandle;
use middleware\CsrfToken;
use Respect\Validation\Validator as v;
use service\Mail;

class User extends Helper
{
    // Constructor
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Create new user
    public function create():string
    {
        $name = $this->PostInput('name');
        $email = $this->PostInput('email');
        $password = $this->PostInput('password');
        $re_password = $this->PostInput('re_password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($name)) {
            return $this->jsonResponse("error", "Name is required!", 422);
        }
        if (!v::email()->validate($email)) {
            return $this->jsonResponse("error", "Email is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->jsonResponse("error", "Password is required!", 422);
        }
        if ($password !== $re_password) {
            return $this->jsonResponse("error", "Passwords do not match!", 422);
        }

        // Database validation
        if (!v::stringType()->length(1, 255)->validate($name)) {
            return $this->jsonResponse("error", "Name is too long! (255 characters max)", 422);
        }
        if (!v::stringType()->length(1, 255)->validate($email)) {
            return $this->jsonResponse("error", "Email is too long! (255 characters max)", 422);
        }
        if (!v::stringType()->length(1, 20)->validate($password)) {
            return $this->jsonResponse("error", "Password is too long! (20 characters max)", 422);
        }

        // Check if email already exists
        $existing = DBHandle::query("SELECT `user_id` FROM user WHERE email = :email", ['email' => $email]);
        if (!empty($existing)) {
            return $this->jsonResponse("error", "Email already exists!", 409);
        }

        // Create new user
        $result = DBHandle::query("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)", [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        // Get user id
        $user_id = (DBHandle::query("SELECT `user_id` FROM user WHERE email = :email", ['email' => $email]));
        if (!$user_id) {

            return $this->jsonResponse("error", "Database error!", 500);
        }
        $user_id = $user_id[0]['user_id'];

        // Get role id
        $role_id = (DBHandle::query("SELECT `role_id` FROM role WHERE role = :role", ['role' => 'user']));
        if (!$role_id) {
            http_response_code(500);
            return $this->jsonResponse("error", "Database error!", 500);
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
            return $this->jsonResponse("error", "Database error!", 500);
        }

        CsrfToken::clearCSRFToken();

        return $this->jsonResponse("success", "User created successfully!");
    }

    // Login
    public function login(): string
    {
        $email = $this->PostInput('email');
        $password = $this->PostInput('password');

        // Form validation
        if (!v::email()->validate($email)) {
            return $this->jsonResponse("error", "Email is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->jsonResponse("error", "Password is required!", 422);
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE email = :email", ['email' => $email]);
        // Check if user exists
        if (empty($user)) {
            return $this->jsonResponse("error", "Invalid email or password!", 401);
        }
        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            return $this->jsonResponse("error", "Invalid email or password!", 401);
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

        return $this->jsonResponse("success", "Login successful!");
    }

    // Logout
    public function logout(): string
    {
        // Destroy  session
        session_unset();
        session_destroy();

        return $this->jsonResponse("success", "Logout successful!");
    }

    // Delete user a
    public function delete(): string
    {
        $password = $this->PostInput('password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->jsonResponse("error", "Password is required!", 422);
        }


        // Validate user
        $user = DBHandle::query("
            SELECT
                *
            FROM user
                INNER JOIN user_has_role ON user.user_id = user_has_role.user_user_id
                INNER JOIN role  ON user_has_role.role_role_id = role.role_id
            WHERE user.user_id = :user_id AND role.role = 'admin';",
            [
                'user_id' => $_SESSION['user']['user_id']
            ]
        );

        $user = $user[0]; // fetch first record

        // check if user admin
        if ($user['role'] === 'admin') {
            return $this->jsonResponse("error", "You cannot delete your admin account!", 401);
        }

        // Check password
        if (!password_verify($password, $user['password'])) {
            return $this->jsonResponse("error", "Invalid password!", 401);
        }

        // Delete user
        $result = DBHandle::query("DELETE FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);
        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        // Destroy  session
        session_unset();
        session_destroy();

        return $this->jsonResponse("success", "User deleted successfully!");
    }

    // change password
    public function setPassword(): string
    {
        $password = $this->PostInput('password');
        $new_password = $this->PostInput('new_password');
        $re_new_password = $this->PostInput('re_new_password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($password)) {
            return $this->jsonResponse("error", "Current password is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($new_password)) {
            return $this->jsonResponse("error", "New password is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($re_new_password)) {
            return $this->jsonResponse("error", "Re-entered password is required!", 422);
        }
        // Database validation
        if (!v::stringType()->length(1, 20)->validate($new_password)) {
            return $this->jsonResponse("error", "Password must be between 1 and 20 characters!", 422);
        }
        if ($new_password !== $re_new_password) {
            return $this->jsonResponse("error", "Passwords do not match!", 422);
        }
        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);

        // Check password
        $user = $user[0]; // fetch first record
        if (!password_verify($password, $user['password'])) {
            return $this->jsonResponse("error", "Invalid password!", 401);
        }

        // Update password
        $result = DBHandle::query("UPDATE user SET password = :password WHERE user_id = :user_id", ['password' => password_hash($new_password, PASSWORD_DEFAULT), 'user_id' => $_SESSION['user']['user_id']]);
        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        // Destroy  session
        unset($_SESSION['user']);

        CsrfToken::clearCSRFToken();
        return $this->jsonResponse("success", "Password changed successfully!");
    }

    // give forgot password page
    public function forgotPassword(): string
    {
        $email = $this->PostInput('email');

        // Form validation
        if (!v::email()->validate($email)) {
            return $this->jsonResponse("error", "Email is required!", 422);
        }

        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE email = :email", ['email' => $email]);

        // Check email exists

        if (!$user) {
            return $this->jsonResponse("error", "Email does not exist!", 401);
        }
        $user = $user[0];

        // Send email
        CsrfToken::clearCSRFToken();
        $mail = new Mail($user['name'], $user['email'], $user['user_id'], (new CsrfToken())->generate(60));
        $mail->setContentResetPassword();
        $mail->sendMail();

        return $this->jsonResponse("success", "Please check your email. Email expired in 1 minute.");
    }

    // update user
    public function update(): string
    {

        $email = $this->PostInput('email');
        $name = $this->PostInput('name');
        $phone = $this->PostInput('phone');
        $address = $this->PostInput('address');
        $whatsapp = $this->PostInput('whatsapp');
        $profile_image = $this->PostInputFile('profilePic');

        // Form validation
        if (!v::email()->validate($email)) {
            return $this->jsonResponse("error", "This email is not valid!", 422);
        }
        if (!v::stringType()->notEmpty()->length(1, 255)->validate($name)) {
            return $this->jsonResponse("error", "Name must be between 1 and 255 characters!", 422);
        }
        if (!v::stringType()->length(1, 15)->phone()->validate($phone)) {
            return $this->jsonResponse("error", "Wrong phone number format!", 422);
        }
        if (!v::notEmpty()->stringType()->validate($address)) {
            return $this->jsonResponse("error", "Wrong address format!", 422);
        }
        if (!v::notEmpty()->stringType()->length(1, 15)->phone()->validate($whatsapp)) {
            return $this->jsonResponse("error", "Wrong whatsapp number format!", 422);
        }

        $query = "UPDATE user SET email = :email, name = :name, phone = :phone, address = :address, whatsapp = :whatsapp";
        $params = [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'whatsapp' => $whatsapp,
            'user_id' => $_SESSION['user']['user_id']
        ];

        if (!empty($profile_image['name'])) {
            $image = $this->uploadImage($profile_image);
            if ($image['status'] === 'error') {
                return $image['response'];
            }
            $query .= ", profile_pic = :profile_image";
            $params['profile_image'] = $image['name'];
        }

        $query .= " WHERE user_id = :user_id";

        $result = DBHandle::query($query, $params);

        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        return $this->jsonResponse("success", "Profile updated!");
    }

    // give new password page
    public function getNewPasswordPage() : void
    {
        $token = $this->getInput('key');
        $id = $this->getInput('id');
        $email = $this->getInput('email');

        // validate token
        $csrf = new CsrfToken();
        $csrf->validate($token);
        $csrf->clear();

        // add data to session
        $_SESSION['forgot']['user_id'] = $id;
        $_SESSION['forgot']['email'] = $email;

        // Give set new password page
        require 'views/user/create_new_password.php';
    }

    // set new password
    public function setNewPassword(): string
    {
        $id = $this->PostInput('id');
        $email = $this->PostInput('email');
        $new_password = $this->PostInput('new_password');
        $re_new_password = $this->PostInput('re_new_password');

        // Form validation
        if (!v::stringType()->notEmpty()->validate($id)) {
            return $this->jsonResponse("error", "ID is required!", 422);
        }
        if (!v::notEmpty()->email()->validate($email)) {
            return $this->jsonResponse("error", "Email is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($new_password)) {
            return $this->jsonResponse("error", "New password is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($re_new_password)) {
            return $this->jsonResponse("error", "Re-entered password is required!", 422);
        }
        // Database validation
        if (!v::stringType()->length(1, 20)->validate($new_password)) {
            return $this->jsonResponse("error", "Password must be between 1 and 20 characters!", 422);
        }
        if ($new_password !== $re_new_password) {
            return $this->jsonResponse("error", "Passwords do not match!", 422);
        }
        // Validate user
        $user = DBHandle::query("SELECT * FROM user WHERE user_id = :user_id AND email = :email", ['user_id' => $id, 'email' => $email]);
        // Check email exists
        $user = $user[0];
        if (!$user) {
            return $this->jsonResponse("error", "Email does not exist!", 401);
        }

        // Update password
        $result = DBHandle::query("UPDATE user SET password = :password WHERE user_id = :user_id", ['password' => password_hash($new_password, PASSWORD_DEFAULT), 'user_id' => $id]);
        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        // Destroy  session
        unset($_SESSION['user']);

        CsrfToken::clearCSRFToken();
        return $this->jsonResponse("success", "Password changed successfully!");
    }

    // get hidden html
    public function getHiddenHtml(): string
    {
        if (!isset($_SESSION['forgot'])) {
            return '';
        }
        return '<input type="hidden" name="id" value="' . $_SESSION['forgot']['user_id'] . '">
                <input type="hidden" name="email" value="' . $_SESSION['forgot']['email'] . '">';
    }

    public function getUserData(): array
    {
        $data =  DBHandle::query("SELECT user_id, name, email, phone, address, whatsapp FROM user where user_id = :user_id;",['user_id' => $_SESSION['user']['user_id']]);
        return $data[0];
    }

    public function getProfilePic(?int $userId = null): string
    {
        // Use the provided user ID, otherwise use the session ID
        $targetUserId = $userId ?? $_SESSION['user']['user_id'];

        $data = DBHandle::query(
            "SELECT profile_pic, name FROM user WHERE user_id = :user_id;",
            ['user_id' => $targetUserId]
        );

        if (empty($data)) {
            // Return a default placeholder if the user is not found
            return 'https://placehold.co/100x100/E2E8F0/4A5568?text=NA';
        }

        $profilePic = $data[0]['profile_pic'];
        $name = $data[0]['name'];

        if (!empty($profilePic)) {
            return '/public/assets/upload/' . $profilePic;
        }

        // Generate initials if no profile picture is set
        $words = explode(" ", trim($name));
        $initials = "";

        foreach ($words as $w) {
            if (!empty($w)) {
                $initials .= strtoupper($w[0]);
            }
        }

        return 'https://placehold.co/100x100/E2E8F0/4A5568?text=' . substr($initials, 0, 2);
    }

    public function getUserName(): string
    {
        return $_SESSION['user']['name'];
    }
}