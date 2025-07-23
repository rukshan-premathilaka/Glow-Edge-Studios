<?php

namespace controller;

use Respect\Validation\Validator as v;

class Admin extends Helper
{
    public function addPortfolioItem(): string
    {
        /*$title = $this->input('title');
        $description = $this->input('description');
        $image = $this->inputImage('image');

        // Validation
        if (!v::stringType()->notEmpty()->validate($title)) {
            http_response_code(422);
            return 'Title is required!';
        }
        if (!v::stringType()->notEmpty()->validate($description)) {
            http_response_code(422);
            return 'Description is required!';
        }
        if (empty($image) || $image['error'] !== 0) {
            http_response_code(422);
            return 'Image is required!';
        }
        if (!v::image()->validate($image['tmp_name'])) {
            http_response_code(422);
            return 'Invalid image format!';
        }

        // Save image to 'uploads/' folder
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
        }

        $imageName = time() . '_' . basename($image['name']); // to avoid duplicate names
        $uploadPath = $uploadDir . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            http_response_code(500);
            return 'Failed to save uploaded image!';
        }

        // Save relative path or name (not full system path)
        return (new Portfolio())->addItem($title, $description, 'uploads/' . $imageName, $_SESSION['user']['user_id']);*/
        return "Admin";
    }


    public function updatePortfolioItem(): string
    {
        return 'success';
    }
    public function deletePortfolioItem(): string
    {
        return 'success';
    }

    public function addService(): string
    {
        return 'success';
    }

    public function updateService(): string
    {
        return 'success';
    }

    public function deleteService(): string
    {
        return 'success';
    }

}