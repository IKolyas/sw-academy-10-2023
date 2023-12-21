<?php

namespace App\Controllers\Api;

use App\Services\Calendar;

class CalendarController extends AbstractApiController
{
    protected bool $requireAuth = false;
    public function actionIndex(): void
    {
        $data = $this->request->getBody();

        $date = date('Y-m', strtotime($data['date'])) ?? date('Y-m');

        $calendar = new Calendar();

        $result = $calendar->getFilledMonth($date);

        $this->response->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
