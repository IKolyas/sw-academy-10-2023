<?php

namespace App\Controllers;

use App\Models\AbstractModel;
use App\Services\Renderers\RendererInterface;
use ReflectionException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'index';
    protected const NOT_FOUND_PAGE_NAME = '404';

    protected bool $useMainTemplate = true;
    protected string $mainTemplate = 'layouts/main';
    protected string $action;
    protected RendererInterface $renderer;

    protected bool $authOnly = false;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        app()->session->remove('errors');

        if ($this->authOnly && !app()->auth->isAuthorized()) {
            header('Location: /auth');
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function runAction($action = null, $params = []): void
    {
        $this->action = $action ?: self::DEFAULT_ACTION;

//      Добавляет префикс 'action' к названию для поиска метода ///actionAll
        $method = "action" . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->bindParams($params, $method);
            $this->$method(...$params);
        } else {
            echo $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
        }
    }

    /** РЕНДЕРИТ шаблон
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function render(string $template, array $params = []): string
    {
        $content = $this->renderer->render($template, $params);

//      Если включена главная страница (шаблон главной страницы) useMainTemplate
        if ($this->useMainTemplate) {
//            TODO: Создать клас для работы с сессиями. Добавить класс в апп. Получить из сессии пользователя.
//            $auth_user = app()->session->IsAuth();

            return $this->renderer->render($this->mainTemplate, compact('content'));
        }

        return $content;
    }

    /**
     * @throws ReflectionException
     */
    private function bindParams(?array &$data, $method): void
    {
        $params = [];

        $reflection = new \ReflectionClass($this);
        $reflectionParameters = $reflection->getMethod($method)?->getParameters();

        if (!$reflectionParameters || !count($reflectionParameters)) {
            $data = $params;
            return;
        }

        foreach ($reflectionParameters as $parameter) {
            $typeName = $parameter->getType()?->getName() ?? '';

            if ($typeName === 'array') {
                $params = [$parameter->getName() => $data];
                continue;
            }

            if (!class_exists($typeName)) {
                continue;
            }

            $class = new $typeName();

            if (!$class instanceof AbstractModel) {
                $params[$parameter->getName()] = $class;
                continue;
            }

            $params[$parameter->getName()] = array_key_exists('id', $data)
                ? $class->find($data['id'])
                : $class;
        }

        $data = $params;
    }
}
