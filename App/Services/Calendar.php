<?php

namespace App\Services;

use App\Models\Record;

class Calendar
{
    private array $dates = [];
    private array $records = [];

    public function getFilledDates(string $monthsFromNow): array
    {
        $yearMonth = $monthsFromNow;

        for ($day = 1; $day <= date('t', strtotime($yearMonth)); $day++) {
            $timestamp = strtotime($yearMonth . '-' . $day);
            $dayToWrite = date('Y-m-d', $timestamp);

            $date = [
                'value' => $dayToWrite,
                'isCurrentMonth' => true
            ];

            $this->addDate($date);
        }

        $this->addPrevDays($yearMonth);
        $this->addNextDays($yearMonth);

        $this->fillDatesRecords();
        return $this->dates;
    }

    public function getFilledMonth(string $month): array
    {
        for ($day = 1; $day <= date('t', strtotime($month)); $day++) {
            $timestamp = strtotime($month . '-' . $day);
            $dayToWrite = date('Y-m-d', $timestamp);

            $date = [
                'value' => $dayToWrite
            ];

            $this->addDate($date);
        }

        $this->fillDatesRecords();

        return $this->dates;
    }

    private function fillDatesRecords(): void
    {

        //var_dump( $this->dates[0]['value']);die;

        $record = new Record();
        $firstDay = $this->dates[0]['value'];
        $lastDay = $this->dates[count($this->dates) - 1]['value'];
        $this->records = $record->getRecordsWithUsers($firstDay, $lastDay);

        //var_dump(count($this->dates),$firstDay, $lastDay);die;

        foreach ($this->dates as &$date) {
            $dateRecords = $this->findRecords($date['value']);

            if ($dateRecords) {
                $date['records'] = $dateRecords;
            }
        }
    }

    private function addPrevDays(string $monthsFromNow): void
    {
        $yearMonth = date('Y-m', strtotime("$monthsFromNow -1 month"));
        $lastDay = date('t', strtotime($yearMonth));

        for ($day = $lastDay; $day >= 24; $day--) {
            $timestamp = strtotime($yearMonth . '-' . $day);

            if (date('D', $timestamp) === 'Sun') {
                break;
            }

            $date = [
                'value' => date('Y-m-d', $timestamp),
                'isCurrentMonth' => false
            ];

            $this->addDate($date, 'unshift');
        }
    }

    private function addNextDays(string $monthsFromNow): void
    {
        $yearMonth = date('Y-m', strtotime("$monthsFromNow +1 month"));

        for ($day = 1; $day <= 6; $day++) {

            $timestamp = strtotime($yearMonth . '-' . $day);

            if (date('D', $timestamp) === 'Mon') {
                break;
            }

            $date = [
                'value' => date('Y-m-d', $timestamp),
                'isCurrentMonth' => false
            ];

            $this->addDate($date);
        }
    }

    private function getDate(int $monthsFromNow, string $format = 'Y-m'): string
    {
        return date($format, strtotime($monthsFromNow . ' month'));
    }

    private function addDate(array $date, string $method = 'add'): void
    {
        match ($method) {
            'add' => $this->dates[] = $date,
            'unshift' => array_unshift($this->dates, $date),
        };
    }

    private function findRecords(string $day): array
    {
        $records = [];
        foreach ($this->records as $record) {
            if ($record['date'] !== $day) {
                continue;
            }

            $records[] = $record;
        }

        return $records;
    }
}