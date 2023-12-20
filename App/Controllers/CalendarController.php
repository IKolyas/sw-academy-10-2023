<?php

namespace App\Controllers;

use App\Base\Request;
use App\Models\Record;
use App\Services\Calendar;
use DateTime;
use Exception;

class CalendarController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionIndex(array $params, ?Calendar $calendar): void
    {
        $monthsFromNow = $params['monthsFromNow'] === null ? date('Y-m') : date('Y-m', strtotime($params['monthsFromNow']));

        //var_dump($monthsFromNow);die;
        $dates = $calendar->getFilledDates($monthsFromNow);

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