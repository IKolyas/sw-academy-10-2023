<?php

namespace App\Controllers;

use App\Base\Response;
use App\Services\Calendar;
use App\Services\Graph;
use App\Models\User;
use App\Services\Scheduler;
use Exception;

class CalendarController extends AbstractController
{

    /**
     * @throws Exception
     */
    public function actionIndex(array $params, ?Calendar $calendar, ?Graph $generateGraph): void
    {
        $monthsFromNow = !isset($params['monthsFromNow']) ? date('Y-m') : date('Y-m', strtotime($params['monthsFromNow']));
        $dates = $calendar->getFilledDates($monthsFromNow);

        //проверка на админа
        $token = app()->cookie->getCookie('token');
        $user = (new User())->find($token,'access_token');

        if (isset($params['generateGraph'])) {
            $start = microtime();
            if ($user->is_admin === 1) {
                $params['generateGraph'] === 'true' ? $generateGraph->generateGraph($dates) : $generateGraph->deleteGraph($dates);
            }

            $end = microtime();

            var_dump($end - $start);
            die();
            header('Location: /calendar?monthsFromNow=' . $monthsFromNow);
        }

        if ($dates) {
            echo $this->render('calendar/index', [
                'days' => $dates,
                'currentMonth' => date('F', strtotime($monthsFromNow)),
                'page' => 'calendar',
                'date' => date('Y-m', strtotime($monthsFromNow)),
            ]);
        } else {
            //TODO: Добавить обработку ошибок
            throw new Exception('Calendars not found');
        }
    }

    public function actionSchedulerGenerate(array $params)
    {
        $start = microtime();
        $scheduler = new Scheduler($params['date']);
        $data = $scheduler->generate();

        foreach ($data as $record) {
            $record->create([
                'user_id' => $record->user_id,
                'date' => $record->date,
            ]);
        }

        $end = microtime();

        var_dump($end - $start);
        die();
        app()->response->redirect('/calendar/index?' . 'monthsFromNow=' . $params['date']);
    }

}
