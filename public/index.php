<?php

//TODO: УБРАТЬ
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use App\Base\Application;
use App\Base\Env;
use App\Base\Request;
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

app()->run($config);