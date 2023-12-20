<?php

namespace App\Base;

use App\Enums\RequestMethodType;

class Request
{
    protected string $uri;
    protected ?string $method;
    protected ?string $controller;
    protected ?string $action;
    protected ?string $params;
    protected ?int $modelId;

    private const URL_PATTERN = "#(?P<controller>\w+(-[A-z]+)*)[/]?(?P<action>[A-z]+)?(?P<modelId>\d+)?[/]?[?]?(?P<params>.*)#ui";

    public function __construct()
    {
        $this->controller = '';
        $this->action = '';
        $this->params = null;
        $this->modelId = null;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->parseRequest();
    }

    protected function parseRequest(): void
    {
        if (preg_match_all(self::URL_PATTERN, $this->uri, $matches)) {
            $this->controller = preg_replace_callback(
                '/((-)(\w))/',
                fn($matches) => strtoupper($matches[3]),
                $matches['controller'][0]
            );
            $this->action = $matches['action'][0];
            $this->params = $matches['params'][0] == '' ? null : $matches['params'][0];
            $this->modelId = $matches['modelId'][0] == '' ? null : $matches['modelId'][0];
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
    public function getParams(): ?array
    {
        return $this->params;
    }

    // id модели из REQUEST_URI
    public function getModelId(): ?int
    {
        return $this->modelId;
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
    public function getParam(string $key): ?string
    {
        $method = $this->getMethod()?->getData();

        if (!isset($method[$key])) {
            return null;
        }

        return $method[$key];
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

    public function getMethod(): RequestMethodType
    {
        return RequestMethodType::tryFrom($this->method);
    }

}