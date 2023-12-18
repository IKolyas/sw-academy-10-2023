<?php

namespace App\Enums;

enum RequestMethodType: string
{
    case GET = 'GET';
    case POST = 'POST';
    public function getData(): array
    {
        return match($this) {
            self::GET => $_GET,
            self::POST => $_POST,
        };
    }
}
