<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends AbstractRepository
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function getModelClassName(): string
    {
        return Profile::class;
    }

    public function findById(int $id): ?\App\Models\AbstractModel
    {
        return $this->getOne($id);
    }
}
