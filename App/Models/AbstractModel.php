<?php

namespace App\Models;

use App\Repositories\AbstractRepository;

abstract class AbstractModel
{
    protected ?AbstractRepository $repository;

    public function find($value, string $col = 'id'): ?AbstractModel
    {
        return $this->repository->getOne($value, $col);
    }

    public function findAll(): ?array
    {
        return $this->repository->all();

    }

    public function findById(int $id): ?AbstractModel
    {
        return $this->repository->getOne($id);
    }
    public function findByDate(int $date): ?AbstractModel
    {
        return $this->repository->getOne($date);
    }

    public function update($fields): int
    {
        return $this->repository->update($fields);
    }

    public function create($values): int
    {
        return $this->repository->create($values);
    }

    public function delete($values): int
    {
        return $this->repository->destroy($values);
    }
}