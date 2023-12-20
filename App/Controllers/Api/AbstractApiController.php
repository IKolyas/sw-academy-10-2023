<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\Models\AbstractModel;

abstract class AbstractApiController
{
    protected string $action;

    protected const DEFAULT_ACTION = 'index';

    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function runAction(?string $action = null): void
    {
        $this->action = $action ?: self::DEFAULT_ACTION;

//      Добавляет префикс 'action' к названию для поиска метода ///actionAll
        $method = "action" . ucfirst($this->action);

        $response = new Response();
        $request = new Request();

        if (!$request->isPost()) {
            $response->json([
                'status' => 405,
                'success' => false,
                'message' => 'Метод недоступен'
            ]);
            return;
        }


        if (method_exists($this, $method)) {
            $request->parseBody();
            $this->$method($request, $response);
            return;
        }

        $response->json([
            'status' => 404,
            'success' => false,
            'message' => 'Метод не существует'
        ]);
    }
}