<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
</head>
<body>

    <h1>Signup</h1>

    <form method="POST" action="/user/signup">
        <label for="name">
            Enter your name
            <input type="text" name="name" required placeholder="Name"><br>
        </label>
        <label for="email">
            Enter your email
            <input type="email" name="email" required placeholder="Email"><br>
        </label>
        <label for="password">
            Enter your password
            <input type="password" name="password" required placeholder="Password"><br>
        </label>
        <label for="re_password">
            Enter your password
            <input type="password" name="re_password" required placeholder="Password"><br>
        </label>
        <?php
            // CSRF
            require "vendor/autoload.php";
            $token = new csrf\CsrfToken();
            echo $token->getInputHtml();
        ?>
        <button type="submit">Register</button>
        <a href="/user/login">Already have an account</a>
    </form>


</body>
</html>