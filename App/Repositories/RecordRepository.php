<?php

namespace App\Repositories;

use App\Models\Record;

class RecordRepository extends AbstractRepository
{
    protected ?string $modelClassName = Record::class;

    public function getTableName(): string
    {
        return 'records';
    }

    public function getModelClassName(): ?string
    {
        return $this->modelClassName;
    }

    public function getByRange(string $from, string $to, string $field = 'id' ): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} BETWEEN :from AND :to";
        return $this->getQuery($sql, ['from' => $from, 'to' => $to]);
    }

    public function getRecordsWithUsers(string $from, string $to): array
    {
        $this->modelClassName = null;

        $sql = "SELECT first_name, last_name, note, records.status, date FROM {$this->tableName} 
        LEFT JOIN users ON records.user_id = users.id WHERE date BETWEEN :from AND :to";

        return $this->getQuery($sql, ['from' => $from, 'to' => $to]);
    }
}