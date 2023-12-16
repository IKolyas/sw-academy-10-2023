<?php

namespace App\Repositories;

use App\Models\Record;

class RecordRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return 'records';
    }

    public function getModelClassName(): string
    {
        return Record::class;
    }
}