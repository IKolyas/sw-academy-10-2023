<?php

namespace App\Repositories;

use App\Models\EditUser;

class EditUserRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return EditUser::class;
    }

    public function findById(int $id): ?\App\Models\AbstractModel
    {
        return $this->getOne($id);
    }
}
