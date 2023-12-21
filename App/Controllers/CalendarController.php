<?php

namespace App\Controllers;

use App\Services\Calendar;
use App\Services\Graph;
use Exception;

class CalendarController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionIndex(array $params, ?Calendar $calendar, ?Graph $generateGraph): void
    {
        //var_dump('ASASUIA');die;
        $monthsFromNow = !isset($params['monthsFromNow']) ? date('Y-m') : date('Y-m', strtotime($params['monthsFromNow']));
        $dates = $calendar->getFilledDates($monthsFromNow);

        if (isset($params['generateGraph']) && $params['generateGraph'] === 'true') {
            $generateGraph->generateGraph($dates);
            header('Location: /calendar?monthsFromNow=' . $params['monthsFromNow']);

        } elseif (isset($params['generateGraph']) && $params['generateGraph'] === 'false') {
            $generateGraph->deleteGraph($dates);
            header('Location: /calendar?monthsFromNow=' . $params['monthsFromNow']);
        }

        if ($dates) {
            echo $this->render('calendar/index', [
                'days' => $dates,
                'currentMonth' => date('F', strtotime($monthsFromNow)),
            ]);
        } else {
            //TODO: Добавить обработку ошибок
            throw new Exception('Calendars not found');
        }
    }

}