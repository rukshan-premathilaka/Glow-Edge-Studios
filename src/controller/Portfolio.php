<?php

namespace controller;

use core\DBHandle;
use middleware\CsrfToken;
use Respect\Validation\Validator as v;

class Portfolio extends Helper
{
    public function __construct()
    {

    }

    public function add(string $title, string $description, string $image, int $authorId): string
    {
        $result = DBHandle::query("INSERT INTO portfolio (title, description, image) VALUES (:title, :description, :image)", [
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);

        if (!$result) {
            return $this->jsonResponse("error", "Database error: Portfolio item not added!", 500);
        }

        return $this->jsonResponse("success", "Portfolio item added!");
    }

    public function update(): string
    {
        return $this->jsonResponse("success", "Portfolio item updated!");
    }

    public function delete(): string
    {
        return $this->jsonResponse("success", "Portfolio item deleted!");
    }

    public static function getAll(): array
    {
        $result = DBHandle::query("SELECT * FROM portfolio");

        if (!$result) {
            die("Database error: Portfolio items not found!");
        }

        return $result;
    }
}