<?php

namespace app\Example\Requests;

use app\Example\Config\Config;

class ExampleRequest
{
    public Config $config;
    public function __construct()
    {
        $this->config = Config::getInstance();
    }
}
