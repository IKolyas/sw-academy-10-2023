<?php

namespace App\Services;

use App\Traits\Singleton;
use PDO;

class DataBase
{
    use Singleton;

    private ?PDO $connection = null;

    protected function getConnection(): ?PDO
    {
        if (is_null($this->connection)) {
            $this->connection = new PDO(
                $this->buildDsn(),
                env('MYSQL_USER', 'user'),
                env('MYSQL_PASSWORD', 'password'),
            );

            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }

    private function buildDsn(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            env('DB_DRIVER', 'mysql'),
            env('DB_HOST', 'localhost'),
            env('MYSQL_DATABASE', 'database'),
            env('DB_CHARSET', 'utf8')
        );
    }

    public function query(string $sql, array $params = []): false|\PDOStatement
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);

        return $pdoStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string|null $className - class name для преобразования в объект
     * @return false|array
     */
    public function queryAll(string $sql, array $params = [], string $className = null): false|array
    {
        $pdoStatement = $this->query($sql, $params);
        if (isset($className)) {
            $pdoStatement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                $className
            );
        }

        return $pdoStatement->fetchAll();
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function getLastInsertId(): false|string
    {
        return $this->getConnection()->lastInsertId();
    }
}