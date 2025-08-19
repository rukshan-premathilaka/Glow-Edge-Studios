<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Error</title>

</head>
<body>

    <div class="screen-size">
        <div class="center-around">
            <h2 style="text-align: center">404 Error</h2>
            <h1 style="text-align: center">Page Not Found!</h1>
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $error = $_SESSION['error'] ?? '';
            unset($_SESSION['error']); // clear flash message after use
            ?>

            <p style="color: red; text-align: center; font-weight: bold; font-size: 20px"><?= htmlspecialchars($error) ?></p>

        </div>
    </div>


</body>
</html>