<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign In - GlowEdge Studios</title>
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
    <h2>Sign In</h2>
    <form id="loginForm" action="/user/login" method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Sign In</button>

        <!-- CSRF Token -->
        <?php
        use middleware\CsrfToken;
        $csrf = new CsrfToken();
        echo $csrf->getInputHtml();
        ?>

    </form>
    <p><a href="/user/forgot_password">Forgot Password?</a></p>
    <p>Don't have an account? <a href="/user/signup">Sign Up</a></p>
</main>

<script src="/public/js/script.js"></script>
<script type="module" src="/public/js/user/login.js"></script>
</body>
</html>
