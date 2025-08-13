<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password - GlowEdge Studios</title>
    <link rel="stylesheet" href="/public/css/style.css" />
</head>
<body>
<header>
    <div class="logo">
        <img src="/public/assets/ui/LOGO.png" alt="Glow Edge Logo" />
        <h1>Glow Edge</h1>
    </div>
</header>

<!-- This page can be accessed from email -->

<main class="form-container">
    <h2>Reset Password</h2>
    <form id="newPassword" action="/user/new_password" method="POST">
        <input type="password" name="new_password" placeholder="New Password" required />
        <input type="password" name="re_new_password" placeholder="Confirm Password" required />
        <button type="submit">Reset Password</button>

        <?php

        use middleware\CsrfToken;
        use controller\User;

        /* User Data */
        $user = new User();
        echo $user->getHiddenHtml();

        /* CSRF Token */
        $csrf = new CsrfToken();
        echo $csrf->getInputHtml();

        ?>
    </form>
</main>

<script src="/public/js/script.js"></script>
<script type="module" src="/public/js/user/new_password.js"></script>
</body>
</html>