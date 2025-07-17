<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <script src="/public/js/main.js"></script>
    <?php
        // CSRF
        $token = new csrf\CsrfToken();
        echo $token->getTokenScriptTag();
    ?>
</head>
<body>

    <h1>Test Page</h1>

    <button onclick="f()">click me</button>

</body>
</html>