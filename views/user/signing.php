<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signing</title>
</head>
<body>
    <h1>Signing</h1>

    <form method="POST" action="/user/signing">
        <label for="email">
            Enter your email
            <input type="email" name="email" required placeholder="Email"><br>
        </label>
        <label for="password">
            Enter your password
            <input type="password" name="password" required placeholder="Password"><br>
        </label>
        <?php
        // CSRF
        $token = new csrf\CsrfToken();
        echo $token->getInputHtml();
        ?>
        <button type="submit">Sign in</button>
        <a href="/user/signup">Create new account</a>
    </form>
</body>
</html>
