<?php


use core\DBHandle;

// SELECT Example
$users = DBHandle::query("SELECT * FROM user",);

echo "<pre>";
print_r($users);
echo "</pre>";