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


}