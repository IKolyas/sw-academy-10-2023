<?php

namespace App\Enums;

class UserStatusType
{
    public const ACTIVE_USER = 1;
    public const INACTIVE_USER = 0;

    public static function getStatusName(int $status): int
    {
        return match ($status) {
            self::ACTIVE_USER => 'Доступен для установки в график',
            self::INACTIVE_USER => 'Не доступен для установки в график',
        };
    }

    public static function getList(): array
    {
        return [
            [
                'value' => self::ACTIVE_USER,
                'label' => 'Доступен для установки в график',
            ],
            [
                'value' => self::INACTIVE_USER,
                'label' => 'Не доступен для установки в график',
            ]
        ];
    }
}
