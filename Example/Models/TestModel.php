<?php

namespace app\Example\Models;

class TestModel extends AbstractModel
{
    public int $age;

    public function getBirthYear(): int
    {
        return (int) date('Y') - $this->age;
    }

    public function getName(): string
    {
        return strtoupper($this->name);
    }
}
