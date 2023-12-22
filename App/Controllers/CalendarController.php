<?php

namespace App\Controllers;

use App\Services\Calendar;
use App\Services\Scheduler;
use Exception;

class CalendarController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function actionIndex(array $params, ?Calendar $calendar): void
    {
        $yearMonth = date('Y-m', strtotime($params['yearMonth'] ?? date('Y-m')));
        $dates = $calendar->getFilledDates($yearMonth);

        echo $this->render('calendar/index', [
            'days' => $dates,
            'currentMonth' => date('F', strtotime($yearMonth)),
            'page' => 'calendar',
            'date' => date('Y-m', strtotime($yearMonth)),
        ]);
    }

    public function actionSchedulerGenerate(array $params): void
    {
        $scheduler = new Scheduler($params['date']);
        $data = $scheduler->generate();

        foreach ($data as $record) {
            $record->create([
                'user_id' => $record->user_id,
                'date' => $record->date,
            ]);
        }

        app()->response->redirect('/calendar/index?' . 'yearMonth=' . $params['date']);
    }

}
