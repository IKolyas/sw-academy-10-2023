<?php

namespace App\Controllers;

use App\Services\Renderers\RendererInterface;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'index';
    protected const NOT_FOUND_PAGE_NAME = '404';

    protected string $mainTemplate = 'layouts/main';
    protected bool $useMainTemplate = true;
    protected string $action;
    protected RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function runAction($action = null, $params = []): void
    {
        $this->action = $action ?: self::DEFAULT_ACTION;

//      Добавляет префикс 'action' к названию для поиска метода ///actionAll
        $method = "action" . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->$method($params);
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

}