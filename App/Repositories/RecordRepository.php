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

    public function getByDateRange(string $from, string $to): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE date BETWEEN :from AND :to";
        return $this->getQuery($sql, ['from' => $from, 'to' => $to]);
    }
}