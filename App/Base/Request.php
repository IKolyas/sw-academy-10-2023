<?php

namespace App\Base;

//TODO:УБРАТЬ
use App\Enums\RequestData;
use App\Enums\RequestMethodType;

class Request
{
    protected string $uri;
    protected ?string $method;
    protected ?string $controller;
    protected ?string $action;
    protected ?string $params;

    private const URL_PATTERN = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";


    public function __construct()
    {
        $this->controller = '';
        $this->action = '';
        $this->params = '';
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->parseRequest();
    }

    protected function parseRequest(): void
    {
        if (preg_match_all(self::URL_PATTERN, $this->uri, $matches)) {
            $this->controller = $matches['controller'][0];
            $this->action = $matches['action'][0];
            $this->params = $matches['params'][0];
        }
    }

    // Имя контроллера из REQUEST_URI
    public function getController(): ?string
    {
        return $this->controller;
    }

    // Имя метода из REQUEST_URI
    public function getAction(): ?string
    {
        return $this->action;
    }

    // Параметры из REQUEST_URI
    public function getParams(): ?string
    {
        return $this->params;
    }

    // Вспомогательные методы для проверки типа запроса. Понадобятся в дальнейшем, чтобы делать меньше проверок
    public function isGet(): bool
    {
        return $this->method == 'GET';
    }

    public function isPost(): bool
    {
        return $this->method == 'POST';
    }

    //  Получить параметр из запроса
    public function getParam(string $key): ?array
    {
        $method = $this->getMethod()?->getData();

        if (!isset($method[$key])) {
            return null;
        }

        return [$key => $method[$key]];
    }

    //  Получить все параметры
    public function getAll(): ?array
    {

        $methodData = $this->getMethod()?->getData();

        if (!$methodData) {
            return null;
        }

        return array_filter($methodData, fn($k) => $k !== 'uri', ARRAY_FILTER_USE_KEY);

    }

    protected function getMethod(): RequestMethodType
    {
        return RequestMethodType::tryFrom($this->method);
    }

}