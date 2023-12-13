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
}