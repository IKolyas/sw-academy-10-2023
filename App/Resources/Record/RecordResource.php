<?php

namespace App\Resources\Record;

use App\Models\Record;

class RecordResource
{

    public static function transformToShow(?Record $record): array
    {
        if (!$record?->id) {
            return [];
        }

        return [
            'id' => $record->id,
            'user_id' => $record->user_id,
            'date' => $record->date,
            'status' => $record->status,
            'type' => $record->type,
            'note' => $record->note,
        ];
    }
}