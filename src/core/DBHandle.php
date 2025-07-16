<?php

namespace core;

use PDO;
use PDOException;

class DBHandle
{
    private static ?PDO $pdo = null;

    private function __construct() {}

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $host = 'localhost';
            $dbname = 'glow_edge_studios';
            $username = 'root';
            $password = 'Rasintha2002@';
            $charset = 'utf8mb4';

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
        $stmt->execute($params);

        // Auto-detect if it's SELECT or not
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