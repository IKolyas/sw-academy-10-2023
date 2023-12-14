<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
use app\Base\Cookie;
use app\Base\Request;

$config = Config::getInstance();
$dbConfig = $config->getDbConfig();
$envConfig = $config->getEnvData();

$allConfig = $config->getConfig();

foreach ($allConfig as $propertyGroup => $properties) {
    echo "$propertyGroup:<br>";
    foreach ($properties as $key => $value) {
        echo "'$key': '$value'<br>";
    }
}

$cookie = new Cookie();
$request = new Request();

