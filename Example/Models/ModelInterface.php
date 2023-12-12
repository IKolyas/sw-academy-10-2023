<?php

namespace app\Example\Models;

use app\Example\Config\Config;

interface ModelInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getDbData(): ?Config;
}
