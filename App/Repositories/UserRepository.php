<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return User::class;
    }

    public function getВutyOfficersByDate(string $date): ?array
    {
        $sql = "SELECT users.id FROM `users` INNER JOIN `records` ON records.user_id = users.id WHERE records.date = :dateRecords";
        return ($this->getQuery($sql, [':dateRecords' => $date]));
    }
}