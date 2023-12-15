<?php

namespace App\Enums;

enum RequestMethodType: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';

    public function getData(): array
    {
        return match($this) {
            self::GET, self::DELETE => $_GET,
            self::POST => $_POST,
            self::PUT => $_REQUEST,
        };
    }
}