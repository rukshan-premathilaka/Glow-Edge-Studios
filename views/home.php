<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Home</title>
</head>
<body>
    <h1>Home Page</h1>


    <?php
    use core\DBHandle;
    $data = DBHandle::query("SELECT user_id, name, email FROM user");
    ?>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php foreach ($data as $user): ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
