<?php

namespace core;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class DBHandle
{
    private static ?PDO $pdo = null;

    private function __construct() {}

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "";
            $username = "";
            $password = "";

            // Check if on Heroku (JAWSDB_URL is set)
            $jawsdb_url = getenv("JAWSDB_URL");

            if ($jawsdb_url) {
                // Parse the Heroku-provided URL
                $url_parts = parse_url($jawsdb_url);
                $host = $url_parts['host'];
                $dbname = ltrim($url_parts['path'], '/');
                $username = $url_parts['user'];
                $password = $url_parts['pass'];
                $charset = 'utf8mb4'; // Heroku's default
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            } else {
                // Fallback for local development using .env file
                $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
                $dotenv->load();

                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $username = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASS'];
                $charset = $_ENV['DB_CHARSET'];

                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            }

            try {
                self::$pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function query(string $sql, array $params = []): array|bool
    {
        $stmt = self::connect()->prepare($sql);

        try {
            $stmt->execute($params);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

        if (str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
            return $stmt->fetchAll();
        }

        return true;
    }

    public static function lastInsertId(): string
    {
        return self::connect()->lastInsertId();
    }
}