<?php

namespace controller;

use Respect\Validation\Validator as v;

class Admin extends Helper
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
             session_start();
        }
    }
    public function addPortfolioItem(): string
    {
        $title = $this->PostInput('title');
        $description = $this->PostInput('description');
        $image = $this->PostInputFile('image');

        // Validate input
        if (!v::stringType()->notEmpty()->validate($title)) {
            return $this->jsonResponse("error", "Title is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($description)) {
            return $this->jsonResponse("error", "Description is required!", 422);
        }

        // Upload image
        $ImageName = $this->uploadImage($image);

        return (new Portfolio())->add($title, $description, $ImageName, $_SESSION['user']['user_id']);
    }

    public function updatePortfolioItem(): string
    {
        $id = $this->PostInput('portfolio_id');
        $title = $this->PostInput('title');
        $description = $this->PostInput('description');
        $image = $this->PostInputFile('image');

        // Validate input
        if (!v::stringType()->notEmpty()->validate($title)) {
            return $this->jsonResponse("error", "Title is required!", 422);
        }
        if (!v::stringType()->notEmpty()->validate($description)) {
            return $this->jsonResponse("error", "Description is required!", 422);
        }

        // Upload image
        $ImageName = $this->uploadImage($image);

        return (new Portfolio())->update($id, $title, $description, $ImageName);
    }

    public function deletePortfolioItem(): string
    {
        $id = $this->PostInput('portfolio_id');
        return (new Portfolio())->delete((int) $id);
    }

    private function uploadImage(array $image): string
    {
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/svg'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        if (!in_array($image['type'], $allowedTypes, true)) {
            return $this->jsonResponse("error", "Only JPG, PNG, and SVG images are allowed!", 422);
        }
        if ($image['size'] > $maxSize) {
            return $this->jsonResponse("error", "Image size should be less than 10MB!", 422);
        }

        // Upload directory
        $uploadDir = __DIR__ . '/../../public/uploads/';

        // Generate unique  filename
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_', true) . '_' . $extension;

        // Full path
        $uploadFile = $uploadDir . $uniqueName;

        // Upload file
        if (!move_uploaded_file($image['tmp_name'], $uploadFile)) {
            die($this->jsonResponse("error", "Image upload failed!", 500));
        }

        return $uniqueName;
    }
}



