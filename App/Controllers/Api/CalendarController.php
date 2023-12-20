<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;

class CalendarController extends AbstractApiController
{
    public function actionIndex(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => $data
        ]);
    }
}