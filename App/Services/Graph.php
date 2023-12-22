<?php

namespace App\Services;

use  App\Models\Record;
use  App\Models\User;

class Graph
{
    function generateGraph(array $dates)
    {
        //удаляем сб и вс
        foreach ($dates as $key=>$date) {
            $currDate = date('D', strtotime($date['value']));
            if ($currDate === 'Sun' || $currDate === 'Sat') {
                unset($dates[$key]);
            }
        }


        $user = new User();
        $users = $user->getBy(1,'status'); //Все сотрудники, готовые дежурить
        $arrayIdDuty = $this->getIdDuty($users);

        //выход из генератора
        if (is_null($arrayIdDuty)) {
            return $dates;
        }

        $oldDutyOfficers = $this->countOldRecords($dates);
        $newListDuty = $this->createGeneralListDuty($oldDutyOfficers, $arrayIdDuty);
        $datesСurrentMonth = $this->getDatesСurrentMonth($dates);

        //сортировка дежурных по кол-ву дежурств
        usort($newListDuty, function($a, $b){
            return ($a['count'] - $b['count']);
        });

        foreach ($datesСurrentMonth as &$day) {
            if (isset($day['records'])) {
                continue;
            }

            foreach ($newListDuty as $key=>$duty) {
                    
                //генерация пользователя на первый день месяца
                $latsDuty = $this->getLastDuty($dates);
                if ($latsDuty !== null && preg_match('/\d{4}-\d{2}-01/', $day['value']) && ($latsDuty['id'] === $duty['id'])) {
        
                    continue;
                }

                $record = new Record();
                $newRecord = [
                    'user_id' => $duty['id'],
                    'date' => $day['value'],
                ];
                $record->create($newRecord);
                $newListDuty[$key]['count'] = $duty['count'] + 1;
                
                //сортировка дежурных по кол-ву дежурств
                usort($newListDuty, function($a, $b){
                    return ($a['count'] - $b['count']);
                });

                $day['records'] = $newRecord;

                break;
            }
        }
    }

    function deleteGraph(array $dates)
    {
        $datesСurrentMonth = $this->getDatesСurrentMonth($dates);

        $firstDate = $datesСurrentMonth[0]['value'];
        $lastDate = $datesСurrentMonth[count($datesСurrentMonth) - 1]['value'];


        $record = new Record();
        $listToDelete = $record->getByRange($firstDate, $lastDate, 'date');


        foreach ($listToDelete as $date) {
            $record->delete($date->id);
        }
    }

    /**Получить даты этого месяца */
    private function getDatesСurrentMonth(array $dates): array
    {
        $datesСurrentMonth = null;

        foreach ($dates as $day) {
            if (!$day['isCurrentMonth']) {
                continue;
            }
            $datesСurrentMonth[] = $day;
        }

        return $datesСurrentMonth;
    }

    /**Создаем новый список с учетом старых записей */
    private function createGeneralListDuty(?array $oldList, array $arrayIdDuty): array
    {
        $newListDuty = is_null($oldList) ? [] : $oldList;

        foreach ($arrayIdDuty as $userId) {

            $isAlreadyExists = false;

            foreach ($newListDuty as $key=>$duty) {
                if ($userId == $duty['id']) {

                    $newListDuty[$key]['count'] += 1;

                    $isAlreadyExists = true;
                    break;
                }
            } 
            if ($isAlreadyExists) {
                continue;
            }

            $newListDuty[] = [
                'id' => $userId,
                'count' => 0,
            ];
        }

        return $newListDuty;
    }

    /**Получаем массив id пользователей со статусом = 1 */
    private function getIdDuty(?array $users): ?array
    {
        $arrayId = null;
        foreach ($users as $user) {
            $arrayId[] = $user->id; 
        }
        return $arrayId;
    }

    /**Получаем последнего дежурного пред. месяца */
    private function getLastDuty(array $dates): ?array
    {
        $latsDuty = null;

        //получаем последний день предыдущего месяца
        $currentMonth = $dates[0]['value'];
        $previousMonth = strtotime($currentMonth . " -1 month");
        $lastDay = date('Y-m-t', $previousMonth);

        //поиск записей в последний день предыдущего месяца
        $record = new Record();
        $lastDayRecords = empty($record->getBy($lastDay, 'date')) ? 
            null : $record->getBy($lastDay, 'date');

        if (is_null($lastDayRecords)) {
            return $latsDuty;
        }
        //поиск дежурного
        foreach ($lastDayRecords as $val) {
            $latsDuty['id'] = $val->user_id;
            break;

        }

        return $latsDuty;
    }

    /** создаем список старых пользователей с счетчиком их дежурств */
    private function countOldRecords(array $dates): ?array
    {
        $user = new User();
        $oldDutyOfficers = [];

        foreach ($dates as $day) {
            if (isset($day['records'])) {

                $user_id = null;
                //получение установленных ранее дежурных
                foreach ($day['records'] as $record) {
                    
                    $user_id = ($user->getВutyOfficersByDate($record['date']))[0]->id;

                    if (empty($oldDutyOfficers)) {
                        $oldDutyOfficers[] = [
                            'id' => $user_id,
                            'count' => 1
                        ];

                        continue;
                    }
                    
                    $isContinue = false;
                    if (!empty($oldDutyOfficers)) {
                        foreach ($oldDutyOfficers as $key=>$duty) {
                            if ($duty['id'] === $user_id) {
                                $oldDutyOfficers[$key]['count'] += 1;
    
                                $isContinue = true;
                            }
                        }
                    }
                    if ($isContinue) {
                        continue;
                    }

                    $oldDutyOfficers[] = [
                        'id' => $user_id,
                        'count' => 1
                    ];
                }
            }
        }

        return $oldDutyOfficers;
    }

}