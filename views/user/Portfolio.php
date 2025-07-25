<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio</title>

    <?php
    // CSRF
    $token = new middleware\CsrfToken();
    echo $token->getScriptTag();
    ?>

</head>
<body>
    <h1>Portfolio</h1>



</body>
</html>