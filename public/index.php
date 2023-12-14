<?php

header('Content-Type: application/json; charset=utf-8');
include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
use app\Base\Request;
use app\Base\Cookie;


$cookie = Cookie::getInstance();
$request = Request::getInstance();

print_r($request->getBody());
print_r($request->getParams());
print_r($request->getMethodRequest());
