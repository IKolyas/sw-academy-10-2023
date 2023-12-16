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

// my code:

// function env($key, $default = null)
// {
//     $env = new Env;
//     return $env->get($key) ?? $default;
// }

// :my code


function env($key, $default = null)
{
    return Env::getInstance()->get($key) ?? $default;
}

function app(): Application
{
    return Application::getInstance();
}

app()->run($config);

// my code:


// $app = new Application;
// $app->run($config);

// print_r(DIRECTORY_SEPARATOR);
// echo '<br>';
// print_r($GLOBALS);

// foreach ($GLOBALS as $key => $value) {
//     print_r($key);
// }
// echo '<br>';
// echo '*********************************';
// echo '<br>';

// foreach ($GLOBALS as $key => $value) {
//     print_r($value);
// }
// echo '<br>';
// print_r($_SERVER['DOCUMENT_ROOT']);
// echo '<br>';
// print_r($config);

// :my code
