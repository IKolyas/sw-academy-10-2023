<?php

namespace App\Repositories;

use App\Models\AbstractModel;
use App\Services\DataBase;

use function PHPSTORM_META\type;

abstract class AbstractRepository implements RepositoryInterface
{
    protected ?DataBase $dataBase;
    protected string $tableName;

    public function __construct()
    {
        $this->dataBase = DataBase::getInstance();
        $this->tableName = $this->getTableName();
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->tableName}";

        return $this->getQuery($sql);
    }

    public function getBy($value, string $column = 'id'): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$column} = :value";

        return $this->getQuery($sql, ['value' => $value]);
    }

    public function getOne($value, string $column = 'id'): ?AbstractModel
    {
        return $this->getBy($value, $column) ? $this->getBy($value, $column)[0] : null;
    }

    public function create(array $params): int
    {
        $paramsList = [];
        $columns = [];

        foreach ($params as $key => $value) {
            if ($key !== 'id') {
                $paramsList[":{$key}"] = $value;
                $columns[] = "`{$key}`";
            }
        }

        $paramsValue = implode(',', array_keys($paramsList));
        $columns = implode(',', $columns);

        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$paramsValue})";
        return $this->save($sql, $paramsList);
    }

    public function update(array $params): int
    {

        //var_dump($params);die;
        $paramsList = [];
        $columns = [];

        foreach ($params as $key => $value) {
            $paramsList[":{$key}"] = $value;
            if ($key !== 'id') {
                $columns[] = "`$key`" . '=' . ":{$key}";
            }
        }

        $columns = implode(', ', $columns);

        $sql = "UPDATE {$this->tableName} SET {$columns} WHERE `id` = :id";

        return $this->save($sql, $paramsList);
    }

    public function destroy(int $id): int
    {
        $sql = "DELETE FROM {$this->tableName} WHERE `id` = :id";

        return $this->save($sql, [':id' => $id]);
    }

    public function save(string $sql, array $params = []): int
    {
        return $this->dataBase->execute($sql, $params);
    }

    public function getQuery(string $sql, array $params = []): array
    {
        return $this->dataBase->queryAll($sql, $params, $this->getModelClassName());
    }

    abstract public function getTableName(): string;

    abstract public function getModelClassName(): ?string;
}