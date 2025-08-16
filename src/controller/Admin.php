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

}



