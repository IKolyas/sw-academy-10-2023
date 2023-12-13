<?php

header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
use app\Base\Cookie;
use app\Base\Request;

$config = Config::getInstance();

$cookie = new Cookie();
$request = new Request();

print_r($request->getMethod());
print_r($request->getParams());
print_r($request->getBody());