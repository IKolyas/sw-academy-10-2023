<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\Enums\StatusCode;
use App\Models\AbstractModel;

abstract class AbstractApiController
{
    protected string $action;
    protected bool $requireAuth = true;
    protected Response $response;
    protected Request $request;

    protected const DEFAULT_ACTION = 'index';

    public function __construct()
    {
        app()->session->remove('errors');

        $isAuthorized = app()->auth->isAuthorized();

        if ($this->requireAuth && !$isAuthorized) {
            (new Response())->json([
                'success' => false,
                'message' => 'Необходима авторизация'
            ], StatusCode::UNAUTHORIZED);
            exit();
        }
    }

    public function runAction(?string $action = null): void
    {
        $this->action = $action ?: self::DEFAULT_ACTION;

//      Добавляет префикс 'action' к названию для поиска метода ///actionAll
        $method = "action" . ucfirst($this->action);

        $this->response = app()->response;
        $this->request = app()->request;

        if (!$this->request->isPost()) {
            $this->response->json([
                'success' => false,
                'message' => 'Метод недоступен'
            ], StatusCode::METHOD_NOT_ALLOWED);
            return;
        }

        if (method_exists($this, $method)) {
            $this->$method();
            return;
        }

        $this->response->json([
            'success' => false,
            'message' => 'Метод не существует'
        ], StatusCode::NOT_FOUND);
    }
}
