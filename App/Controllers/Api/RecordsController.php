<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;

class RecordsController extends AbstractApiController
{
    protected bool $requireAuth = false;

    public function actionIndex(Request $request, Response $response): void
    {

        $response->json([
            'status' => 200,
            'success' => true,
            'message' => 'Hello world!'
        ]);
    }

    public function actionRecords(Request $request, Response $response): void
    {
        $data = $request->getAll();

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => $data
        ]);
    }
}