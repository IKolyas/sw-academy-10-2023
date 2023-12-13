<?php

use App\Base\Application;
use App\Base\Env;

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$config = require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "../config/main.php";

function env($key, $default = null)
{
    return Env::getInstance()->get($key) ?? $default;
}

function app(): Application
{
    return Application::getInstance();
}

app()->run($config);

