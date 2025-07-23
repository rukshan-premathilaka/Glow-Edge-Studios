<?php

namespace controller;

use core\DBHandle;
use middleware\CsrfToken;
use Respect\Validation\Validator as v;

class Portfolio
{
    private string $title;
    private string $description;
    private String $image;
    private int $authorId;


    public function addItem(string $title, string $description, string $image, int $authorId): string
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->authorId = $authorId;

        $result = DBHandle::query("INSERT INTO portfolio (title, description, image) VALUES (:title, :description, :image)", [
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image
        ]);

        if (!$result) {
            http_response_code(500);
            return 'Database error';
        }




        return 'success';
    }

    public function updateItem(): string
    {
        return 'success';
    }

    public function deleteItem(): string
    {
        return 'success';
    }
}