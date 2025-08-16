<?php

namespace controller;

class Helper
{
    protected function PostInput(string $key): string {
        return isset($_POST[$key]) ? trim($_POST[$key]) : '';
    }

    protected function PostInputFile(string $key): array {
        return $_FILES[$key] ?? [];
    }

    protected function getInput(string $key): string
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : '';
    }

    protected function jsonResponse($status, $message, $code = 200, $data = null): string
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $response = [
            'status' => $status,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        try {
            return json_encode($response, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            die($e->getMessage());
        }
    }

    protected function uploadImage(array $image): array
    {
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/jpg'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        if (!in_array($image['type'], $allowedTypes, true)) {
            return [
                'status' => 'error',
                'response' => $this->jsonResponse("error", "Only JPG, JPEG, PNG, and SVG images are allowed!", 422),
                'name' => null,
            ];
        }
        if ($image['size'] > $maxSize) {
            return [
                'status' => 'error',
                'response' => $this->jsonResponse("error", "Image size should be less than 10MB!", 422),
                'name' => null,
            ];
        }

        // Upload directory
        $uploadDir = __DIR__ . '/../../public/assets/upload/';

        // Generate unique  filename
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $uniqueName = str_replace('.', '', uniqid('img_', true)) . '.' . $extension;


        // Full path
        $uploadFile = $uploadDir . $uniqueName;

        // Upload file
        if (!move_uploaded_file($image['tmp_name'], $uploadFile)) {
            return [
                'status' => 'error',
                'response' => $this->jsonResponse("error", "Image upload failed!", 500),
                'name' => null,
            ];
        }

        return [
            'status' => 'success',
            'name' => $uniqueName,
        ];
    }

}