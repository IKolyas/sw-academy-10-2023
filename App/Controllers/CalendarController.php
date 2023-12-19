<?php

namespace App\Controllers;

use App\Base\Request;
use App\Models\Record;
use App\Services\Calendar;
use Exception;

class CalendarController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionIndex(array $params, ?Calendar $calendar): void
    {
        $record = new Record();
        $records = $record->findAll();

        $monthsFromNow = $params['monthsFromNow'] ?? 0;
        $dates = $calendar->getFilledDates($monthsFromNow);
        var_dump($records);

        if ($records) {
            echo $this->render('calendar/index', [
                ...$records,
                'days' => $dates,
                'currentMonth' => date('F', strtotime($monthsFromNow . ' month')),
            ]);
        } else {
            //TODO: Добавить обработку ошибок
            throw new Exception('Calendars not found');
        }
    }

}