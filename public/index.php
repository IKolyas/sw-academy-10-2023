<?php

use App\Base\Application;
use App\Base\Env;


require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$config = require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "../config/main.php";

function env($key, $default = null)
{
    return Env::getInstance()->get($key) ?? $default;
}

$defaultMode = 'development';
$envMode = env('APP_MODE', $defaultMode);

if ($envMode === $defaultMode) {
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors', 'On');

    error_reporting(E_ALL);
}

function app(): Application
{
    return Application::getInstance();
}

app()->run($config);
