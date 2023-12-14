<?php

namespace app\Base;

class Request
{
    public readonly ?array $data;

    function __construct()
    {

        $this->data = match ($this->getRequestMethod()) {
            'GET' => $this->getDataGet(),
            'POST' => $this->getDataPost(),
            'PUT' => $this->processAjax(),
            'DELETE' => $this->processAjax(),
        };

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

    public function processAjax()
    {

        //TODO: реализовать метод
        switch ($this->getRequestMethod()) {
            case 'PUT':
                $dataPut = file_get_contents("php://input");
                $this->data = $this->processAjax();
                break;
            case 'DELETE':
                $this->data = $this->processAjax();
                break;
        }

        $putData = file_get_contents("php://input");
        $data = json_decode($putData);
    }
}
