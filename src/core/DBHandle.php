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
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $charset = $_ENV['DB_CHARSET'];

            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

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