<?php

namespace app\Example\Models;

class ExampleModel extends AbstractModel
{
    public function __construct(int $id)
    {
        parent::__construct($id);

        $this->dbData->setConfig(['host' => '127.0.0.1', 'port' => '3307']);
    }
}
