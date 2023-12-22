<?php

namespace App\Controllers;

use App\Services\Calendar;
use App\Services\Graph;
use App\Models\User;
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
            if ($user->is_admin === 1) {
                $params['generateGraph'] === 'true' ? $generateGraph->generateGraph($dates) : $generateGraph->deleteGraph($dates);
            }
            header('Location: /calendar?monthsFromNow=' . $monthsFromNow);
        }

        if ($dates) {
            echo $this->render('calendar/index', [
                'days' => $dates,
                'currentMonth' => date('F', strtotime($monthsFromNow)),
                'page' => 'calendar'
            ]);
        } else {
            //TODO: Добавить обработку ошибок
            throw new Exception('Calendars not found');
        }
    }

}
