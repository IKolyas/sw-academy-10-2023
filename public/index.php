<?php

use App\Base\Application;
use App\Base\Env;

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

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
echo '<br>';
// print_r($GLOBALS);

// foreach ($GLOBALS as $key => $value) {
//     print_r($key);
// }
echo '<br>';
echo '*********************************';
echo '<br>';

// foreach ($GLOBALS as $key => $value) {
//     print_r($value);
// }
echo '<br>';
// print_r($_SERVER['DOCUMENT_ROOT']);
echo '<br>';
// print_r($config);

// :my code
