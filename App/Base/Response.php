<?php

namespace App\Base;

use App\Enums\StatusCode;

class Response
{
    public function redirect(string $action = '/'): void
    {
        header("Location: $action");
    }

    public function json(array $data, StatusCode $status = StatusCode::OK): void
    {
        header('Content-Type: application/json');
        http_response_code($status->value);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
