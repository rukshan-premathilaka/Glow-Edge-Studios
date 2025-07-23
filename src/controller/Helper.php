<?php

namespace controller;

class Helper
{
    protected function PostInput(string $key): string {
        return isset($_POST[$key]) ? trim($_POST[$key]) : '';
    }

    protected function inputPImage(string $key): array {
        return $_FILES[$key] ?? [];
    }

    protected function getInput(string $key): string
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : '';
    }


}