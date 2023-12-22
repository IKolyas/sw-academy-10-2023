<?php

namespace App\Enums;

enum RecordStatusType: int
{
    case WAITING_FOR_DUTY = 0;
    case DUTY_COMPLETED = 1;

    public function label(): string
    {
        return match ($this) {
            self::WAITING_FOR_DUTY => 'Ожидает дежурства',
            self::DUTY_COMPLETED => 'Продежурил',
        };
    }

    public static function getList(): array
    {
        return array_map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ], self::cases());
    }
}