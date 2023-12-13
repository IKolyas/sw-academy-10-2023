<?php

namespace app\Base;

class Request
{
    public readonly ?array $data;

    function __construct()
    {
        switch ($this->getRequestMethod()) {
            case 'GET':
                $this->data = $this->getDataGet();
                break;
            case 'POST':
                $this->data = $this->getDataPost();
                break;
        }

    }

    public function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function getDataPost(): ?array
    {
        return $_POST ?? null;
    }

    private function getDataGet(): ?array
    {
        return $_GET ?? null;
    }

    
}
