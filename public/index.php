<?php

use App\Base\Application;
use App\Base\Env;
use App\Enums\EnvModeType;
use App\Services\AppEnvMode;

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$envMode = env('APP_MODE', EnvModeType::PRODUCTION->value);
AppEnvMode::setMode(EnvModeType::tryFrom($envMode));

$config = require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "../config/main.php";

function env($key, $default = null)
{
    return Env::getInstance()->get($key) ?? $default;
}

function app(): Application
{
    return Application::getInstance();
}

try {
    app()->run($config);
} catch (ReflectionException $e) {
    echo $e->getMessage();
}