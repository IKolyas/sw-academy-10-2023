<?php

namespace app\Base;

class Request
{
    private ?array $requestBody;
    private ?string $method;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestBody = file_get_contents('php://input');
        if ($requestBody) {
            $this->requestBody = json_decode($requestBody, true);
        }

    }

    private function getDataPost(): ?array
    {
        return $_POST ?? null;
    }

    private function getDataGet(): ?array
    {
        return $_GET ?? null;
    }
    public function getRequestMethod(): ?string {
        return $this->method;
    }

    public function getRequestBody(): ?array {
        return $this->requestBody;
    }

}