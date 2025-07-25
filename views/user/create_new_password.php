<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Document</title>
</head>
<body>

<h1>Create New password</h1>

<form method="POST" action="/user/new_password">

    <label for="new_password">
        Enter your new password
        <input type="password" name="new_password" required placeholder="New password"><br>
    </label>
    <label for="re_new_password">
        Enter again new your password
        <input type="password" name="re_new_password" required placeholder="New password again"><br>
    </label>

    <?php
        // CSRF
        $token = new middleware\CsrfToken();
        echo $token->getInputHtml();

        // User ID and EMAIL
        $data = new Controller\User();
        echo $data->getHiddenHtml();
    ?>

    <button type="submit">Change password</button>

</body>
</html>
