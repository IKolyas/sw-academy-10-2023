<?php

namespace App\Enums;

class RecordStatusType
{
    public const WAITING_FOR_DUTY = 0;
    public const DUTY_COMPLETED = 1;

    public static function getRecordStatus(int $status): string
    {
        return match ($status) {
            self::WAITING_FOR_DUTY => 'Ожидает дежурства',
            self::DUTY_COMPLETED => 'Продежурил',
        };
    }

    public static function getList(): array
    {
        return [
            [
                'value' => self::WAITING_FOR_DUTY,
                'label' => 'Ожидает дежурства',
            ],
            [
                'value' => self::DUTY_COMPLETED,
                'label' => 'Продежурил',
            ]
        ];
    }
}