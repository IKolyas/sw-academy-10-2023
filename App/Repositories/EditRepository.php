<?php

namespace App\Repositories;

use App\Models\Edit;

class EditRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return Edit::class;
    }

    public function findById(int $id): ?\App\Models\AbstractModel
    {
        return $this->getOne($id);
    }
}
