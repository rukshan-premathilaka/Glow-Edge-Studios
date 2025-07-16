<?php


$password = 'mySecret123mySecret123mySecret123mySecret123mySecret123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword;

if (password_verify($password, $hashedPassword)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
