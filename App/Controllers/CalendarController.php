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
        $monthsFromNow = $params['monthsFromNow'] ?? 0;
        $dates = $calendar->getFilledDates($monthsFromNow);

        if ($dates) {
            echo $this->render('calendar/index', [
                'days' => $dates,
                'currentMonth' => date('F', strtotime($monthsFromNow . ' month')),
                'attendant' => $this->attendant,
                'totalDuties' => $this->totalDuties,
                'totalMissedDuties' => $this->totalMissedDuties,
                'page' => 'calendar'
            ]);
        } else {
            //TODO: Добавить обработку ошибок
            throw new Exception('Calendars not found');
        }
    }

}
