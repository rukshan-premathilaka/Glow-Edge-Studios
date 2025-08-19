<?php
// Check for the JAWSDB_URL environment variable
$is_heroku = getenv("JAWSDB_URL");

if ($is_heroku) {
    // We are on Heroku, parse the URL for connection details
    $dbparts = parse_url($is_heroku);
    $servername = $dbparts['host'];
    $username = $dbparts['user'];
    $password = $dbparts['pass'];
    $dbname = ltrim($dbparts['path'], '/');

} else {
    // Fallback for local development
    $servername = "localhost";
    $username = "your_local_db_username";
    $password = "your_local_db_password";
    $dbname = "your_local_db_name";
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to the database! 🥳";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Don't forget to close the connection when you are done
$conn = null;
