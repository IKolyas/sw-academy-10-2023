<?php

namespace App\Repositories;

use App\Models\AbstractModel;

interface RepositoryInterface
{
    public function all(): array;

    public function getBy($value, string $column = 'id'): array;

    public function create(array $params): int;

    public function update(array $params): int;

    public function destroy(int $id): int;

    public function getTableName(): string;

    public function getModelClassName(): ?string;

    public function getQuery(string $sql, array $params = []): array;

    public function getOne(string $value, string $column): ?AbstractModel;
}