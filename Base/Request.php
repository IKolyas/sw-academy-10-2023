<?php

namespace app\Base;

class Request
{
    private ?array $requestParams;
    private ?array $requestBody;
    private ?string $method;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestBody = file_get_contents('php://input');
        $this->requestBody = json_decode($requestBody, true);
        $this->requestParams = $_REQUEST;
    }

    public function getRequestMethod(): ?string {
        return $this->method;
    }

    public function getRequestParams(): ?array {
        return $this->requestParams;
    }

    public function getRequestBody(): ?array {
        return $this->requestBody;
    }

}