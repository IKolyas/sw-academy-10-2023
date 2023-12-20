<?php

namespace App\Base;

class Response
{
    public function redirect(string $action = '/'): void
    {
        header("Location: $action");
    }

    public function json(array $data): void
    {
        header('Content-Type: application/json');
        http_response_code($data['status'] ?? 200);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
