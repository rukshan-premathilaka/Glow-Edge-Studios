<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Document</title>
</head>
<body>

    <h1>Change password</h1>

    <form method="POST" action="/user/forgot_password">
        <label for="email">
            Enter your email
            <input type="email" name="email" required placeholder="Email"><br>
        </label>
        <?php
        // CSRF
        $token = new middleware\CsrfToken();
        echo $token->getInputHtml();
        ?>
        <button type="submit">Change password</button>
    </form>

</body>
</html>
