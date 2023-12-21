<?php

namespace App\Services;

use  App\Models\Record;
use  App\Repositories\UserRepository;
use  App\Repositories\RecordRepository;

class Graph
{
    function generateGraph(array $dates)
    {
        $userRepository = new UserRepository();
        $users = $userRepository->getBy(1,'status'); //Все сотрудники, готовые дежурить
        $arrayIdDuty = $this->getIdDuty($users);

        //выход из генератора
        if (is_null($arrayIdDuty)) {
            return $dates;
        }

        $oldDutyOfficers = $this->countOldRecords($dates);

        $newListDuty = $this->createGeneralListDuty($oldDutyOfficers, $arrayIdDuty);

        $datesСurrentMonth = $this->getDatesСurrentMonth($dates);

        $maximumNumberDuty = ceil(count($datesСurrentMonth)/count($newListDuty));
        

        //var_dump($maximumNumberDuty);die;

        //сортировка дежурных по кол-ву дежурств
        usort($newListDuty, function($a, $b){
            return ($a['count'] - $b['count']);
        });

        foreach ($datesСurrentMonth as &$day) {
            if (isset($day['records'])) {
                continue;
            }

            $isBreak = false;

            /* foreach ($newListDuty as &$duty) {

                //var_dump($duty['id']);
                if ($duty['count'] == $maximumNumberDuty) {
                    //$isBreak = true;
                    echo "EYYY";
                    continue;
                }
                    
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
                $duty['count'] += 1;

                //сортировка дежурных по кол-ву дежурств
                usort($newListDuty, function($a, $b){
                    return ($a['count'] - $b['count']);
                });

                $day['records'] = $newRecord;

            } */

            /* if ($isBreak) {
                continue;
            } */

            foreach ($newListDuty as $key=>$duty) {
                    
                /* if ($duty['count'] == $maximumNumberDuty) {
                    break;
                } */

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
        /* var_dump($newListDuty);die;
        var_dump($datesСurrentMonth);die; */
        
    }

    function deleteGraph(array $dates)
    {
        $datesСurrentMonth = $this->getDatesСurrentMonth($dates);

        $firstDate = $datesСurrentMonth[0]['value'];
        $lastDate = $datesСurrentMonth[count($datesСurrentMonth) - 1]['value'];


        $recordRepository = new RecordRepository();
        $listToDelete = $recordRepository->getByRange($firstDate, $lastDate, 'date');


        foreach ($listToDelete as $date) {
            $recordRepository->destroy($date->id);
        }
    }

    /**Получить даты этого месяца */
    function getDatesСurrentMonth(array $dates): array
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
    function createGeneralListDuty(?array $oldList, array $arrayIdDuty): array
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
    function getIdDuty(?array $users): ?array
    {
        $arrayId = null;
        foreach ($users as $user) {
            $arrayId[] = $user->id; 
        }
        return $arrayId;
    }

    /**Получаем последнего дежурного пред. месяца */
    function getLastDuty(array $dates): ?array
    {
        $latsDuty = null;

        //получаем последний день предыдущего месяца
        $dateInTheMiddle = (int)(count($dates)/2);
        $currentMonth = $dates[$dateInTheMiddle]['value'];
        $previousMonth = strtotime("$currentMonth -1 month");
        $lastDay = date('Y-m-t', $previousMonth);

        //поиск записей в последний день предыдущего месяца
        $recordRepository = new RecordRepository();
        $lastDayRecords = empty($recordRepository->getBy($lastDay, 'date')) ? 
            null : $recordRepository->getBy($lastDay, 'date');

        if (is_null($lastDayRecords)) {
            return $latsDuty;
        }
        //поиск дежурного
        foreach ($lastDayRecords as $record) {
            $latsDuty['id'] = $record->user_id;
            break;

        }

        return $latsDuty;
    }

    /** создаем список старых пользователей с счетчиком их дежурств */
    function countOldRecords(array $dates): ?array
    {
        $userRepository = new UserRepository();
        $oldDutyOfficers = [];

        foreach ($dates as $day) {
            if (isset($day['records'])) {

                $user_id = null;
                //получение установленных ранее дежурных
                foreach ($day['records'] as $record) {
                    $sql = "SELECT users.id FROM `users` INNER JOIN `records` ON records.user_id = users.id WHERE records.date = :dateRecords";
                    
                    $user_id = ($userRepository->getQuery($sql, [':dateRecords' => $record['date']]))[0]->id;


                    if (empty($oldDutyOfficers)) {
                        $oldDutyOfficers[] = [
                            'id' => $user_id,
                            'count' => 1
                        ];

                        continue;
                    }
                    
                    $isContinue = false;
                    if (!empty($oldDutyOfficers)) {
                        foreach ($oldDutyOfficers as $key=>$user) {
                            if ($user['id'] === $user_id) {
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