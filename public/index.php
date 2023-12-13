<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;

$config = Config::getInstance();
$dbConfig = $config->getDbConfig();
$envConfig = $config->getEnvConfig();

$allConfig = $config->getConfig();

foreach ($allConfig as $propertyGroup => $properties) {
    echo "$propertyGroup:<br>";
    foreach ($properties as $key => $value) {
        echo "'$key': '$value'<br>";
    }
}



