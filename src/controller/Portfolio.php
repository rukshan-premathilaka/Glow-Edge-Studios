<?php

namespace controller;

use core\DBHandle;

class Portfolio extends Helper
{
    public function __construct()
    {

    }

    public function add(string $title, string $description, string $image): string
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

    public function update(int $id, string $title, string $description, string $image): string
    {

        return $this->jsonResponse("success", "Portfolio item updated!");
    }

    public function delete(int $id): string
    {
        $result = DBHandle::query("DELETE FROM portfolio WHERE portfolio_id = :id", [
            'id' => $id
        ]);

        if (!$result) {
            return $this->jsonResponse("error", "Database error: Portfolio item not deleted!", 500);
        }

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