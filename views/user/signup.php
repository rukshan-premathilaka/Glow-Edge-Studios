

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up - GlowEdge Studios</title>
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
        <h2>Create Account</h2>
        <form id="signupForm" method="POST" action="/user/signup">
            <input type="text" name="name" placeholder="Full Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="re_password" placeholder="Confirm Password" required />
            <button type="submit">Sign Up</button>

            <!-- CSRF Token -->
            <?php
            use middleware\CsrfToken;
            $csrf = new CsrfToken();
            echo $csrf->getInputHtml();
            ?>

        </form>
        <p>Already have an account? <a href="/user/login">Sign In</a></p>
    </main>

<script src="/public/js/script.js"></script>
<script type="module" src="/public/js/user/signup.js"></script>
</body>
</html>
