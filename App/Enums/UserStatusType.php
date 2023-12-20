<?php

namespace App\Enums;

class UserStatusType
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public static function getStatusName(int $status): int
    {
        return match ($status) {
            self::ACTIVE => 1,
            self::INACTIVE => 0,
        };
    }
}