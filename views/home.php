<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Home</title>
</head>
<body>
<h1>Home Page</h1>

<table>
    <tr>
        <th>Method</th>
        <th>Path</th>
        <th>Handler</th>
        <th>Middleware</th>
        <th>Action</th> <!-- New column -->
    </tr>

    <?php
    $routes = $_SESSION['router'] ?? [];

    foreach ($routes as $route) {
        $path = $route['path'];
        $method = strtoupper($route['method']);
        $handler = $route['handler'];
        $middleware = $route['middleware'];

        // Create button only for GET methods
        $actionButton = ($method === 'GET')
            ? "<a href='/$path'><button>Visit</button></a>"
            : "-";

        echo "<tr>
                    <td>{$method}</td>
                    <td>{$path}</td>
                    <td>{$handler}</td>
                    <td>{$middleware}</td>
                    <td>{$actionButton}</td>
                  </tr>";
    }
    ?>
</table>
</body>
</html>
