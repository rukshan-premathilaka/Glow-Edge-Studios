<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password - GlowEdge Studios</title>
    <link rel="stylesheet" href="/public/css/style.css" />
</head>
<body>
<header>
    <div class="logo">
        <img src="/public/assets/ui/LOGO.png" alt="Glow Edge Logo" />
        <h1>Glow Edge</h1>
    </div>
</header>

<main class="form-container">
    <h2>Forgot Password</h2>
    <form id="forgotForm" method="POST" action="/user/forgot_password">
        <input type="email" name="email" placeholder="Enter your email" required />
        <button type="submit">Send Reset Link</button>

        <!-- CSRF Token -->
        <?php
        use middleware\CsrfToken;
        $csrf = new CsrfToken();
        echo $csrf->getInputHtml();
        ?>

    </form>
    <p><a href="/user/login">Back to Sign In</a></p>
</main>


<script src="/public/js/script.js"></script>
<script type="module" src="/public/js/user/forgot.js"></script>
</body>
</html>
