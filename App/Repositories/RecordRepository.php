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

    public function getByRange(string $from, string $to, string $field = 'id' ): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} BETWEEN :from AND :to";
        return $this->getQuery($sql, ['from' => $from, 'to' => $to]);
    }
}