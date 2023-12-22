<?php

namespace App\Services;

use App\Enums\UserStatusType;
use App\Models\AbstractModel;
use App\Models\Record;
use App\Models\User;

class Scheduler
{
    protected string $currentMonth = '';
    protected Record|null $lastMonthRecord = null;
    protected array $activeUserList = [];
    protected array $currentMonthRecords = [];
    protected array $currentMonthDates = [];
    protected array $datesToGenerate = [];


    public function __construct(string $yearMonth)
    {
        $this->currentMonth = $yearMonth;
        $this->lastMonthRecord = $this->getPrevMonthLastDate();
        $this->activeUserList = $this->getActiveUserList();
        $this->currentMonthRecords = $this->getCurrentMonthRecords();
        $this->currentMonthDates = $this->getCurrentMonthDates();
        $this->datesToGenerate = $this->prepareForGenerate();
    }

    private function getPrevMonthLastDate(): AbstractModel|Record|null
    {
        $record = new Record();
        return $record->find(date('Y-m-d', strtotime($this->currentMonth . ' -1 month')), 'date');
    }

    private function getActiveUserList(): array
    {
        $user = new User();

        return array_column($user->getBy(UserStatusType::ACTIVE_USER->value, 'status'), 'id');
    }

    private function getCurrentMonthRecords(): array
    {
        $record = new Record();
        $dateFrom = $this->currentMonth . '-01';
        $dateTo = date('Y-m-t', strtotime($this->currentMonth));
        $records = $record->getByRange($dateFrom, $dateTo, 'date');

        return array_reduce($records, function ($acc, $record) {
            $acc[$record->date] = $record;
            return $acc;
        }, []);
    }

    private function getCurrentMonthDates(): array
    {

        $calendarService = new Calendar();
        $calendarService->getCurrentMonth($this->currentMonth);
        $dates = array_filter($calendarService->getDates(), fn($date) => !$date['isHoliday']);

        return array_reduce($dates, function ($acc, $date) {
            $record = new Record();
            $record->date = $date['value'];
            $acc[$date['value']] = $record;

            return $acc;
        }, []);
    }

    private function prepareForGenerate(): array
    {
        return array_diff_key($this->currentMonthDates, $this->currentMonthRecords);
    }

    public function generate(): array
    {
        if ($this->lastMonthRecord?->user_id === current($this->activeUserList)) {
            next($this->activeUserList);
        }

        return array_map(function (Record $record) {
            $record->user_id = current($this->activeUserList);

            if (!next($this->activeUserList)) {
                reset($this->activeUserList);
            };

            return $record;

        }, $this->datesToGenerate);
    }

    public static function deleteSchedule($currentMonth): void
    {
        $calendarService = new Calendar();
        $calendarService->getCurrentMonth($currentMonth);

        $dates = $calendarService->getDates();

        $firstDate = $dates[0]['value'];
        $lastDate = $dates[count($dates) - 1]['value'];

        $record = new Record();
        $listToDelete = $record->getByRange($firstDate, $lastDate, 'date');


        foreach ($listToDelete as $date) {
            $record->delete($date->id);
        }
    }

}
