<?php

namespace app\Example\Models;

use app\Example\Config\Config;

abstract class AbstractModel implements ModelInterface
{
    protected string $name;
    protected ?Config $dbData;

    public function __construct(public int $id)
    {
        $this->name = 'ExampleName';
        $this->dbData = Config::getInstance();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDbData(): ?Config
    {
        return $this->dbData;
    }
}
