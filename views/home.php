<?php

use middleware\CsrfToken;
use controller\Portfolio;

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Home</title>

    <?php
    // CSRF
    $token = new CsrfToken();
    echo $token->getScriptTag();
    ?>

</head>
<body>

    <h1>Home Page</h1>

    <table>
        <tr>
            <th>Portfolio ID</th><th>Title</th><th>Description</th><th>Image</th>
        </tr>
        <?php
        $portfolios = Portfolio::getAll();
        foreach ($portfolios as $portfolio): ?>
        <tr>
            <td><?= htmlspecialchars($portfolio['portfolio_id']) ?></td>
            <td><?= htmlspecialchars($portfolio['title']) ?></td>
            <td><?= htmlspecialchars($portfolio['description']) ?></td>
            <td><?= htmlspecialchars($portfolio['image']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
