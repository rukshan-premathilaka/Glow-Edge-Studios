<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>

    <h2>Add Portfolio</h2>
    <form method="POST" action="portfolio/add" enctype="multipart/form-data">
        <label for="title">
            Title
            <input type="text" name="title" required placeholder="Title"><br>
        </label>
        <label for="description">
            Description
            <input type="text" name="description" required placeholder="Description"><br>
        </label>
        <label for="image">
            Image
            <input type="file" name="image" required placeholder="Image"><br>
        </label>
        <button type="submit">Add</button>
    </form>

    <br>
    <h2>Update Portfolio</h2>
    <form method="POST" action="portfolio/add" enctype="multipart/form-data">
        <label for="title">
            ID
            <input type="text" name="portfolio_id" required placeholder="Title"><br>
        </label>
        <label for="title">
            Title
            <input type="text" name="title" required placeholder="Title"><br>
        </label>
        <label for="description">
            Description
            <input type="text" name="description" required placeholder="Description"><br>
        </label>
        <label for="image">
            Image
            <input type="file" name="image" required placeholder="Image" accept="image/*" value=""><br>
        </label>
        <button type="submit">Add</button>
    </form>

    <br>

    <h2>Delete Portfolio</h2>
    <form method="POST" action="portfolio/add" enctype="multipart/form-data">
        <label for="title">
            ID
            <input type="text" name="portfolio_id" required placeholder="Title"><br>
        </label>
        <button type="submit">Add</button>
    </form>



</body>
</html>