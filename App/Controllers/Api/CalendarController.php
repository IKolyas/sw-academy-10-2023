<?php

namespace App\Controllers\Api;

use App\Base\Request;
use App\Base\Response;
use App\Services\Calendar;

class CalendarController extends AbstractApiController
{
    public function actionIndex(Request $request, Response $response): void
    {
        $data = $request->getBody();

        $date = $data['date'] ?? date('Y-m');

        $calendar = new Calendar();

        $result = $calendar->getFilledMonth($date);

        $response->json([
            'status' => 200,
            'success' => true,
            'data' => $result
        ]);
    }
}