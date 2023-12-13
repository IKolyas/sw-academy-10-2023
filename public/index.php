<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
use app\Base\Request;
use app\Base\Cookie;

/* $config = Config::getInstance();
$dbConfig = $config->getDbConfig();
$envConfig = $config->getEnvData();

$allConfig = $config->getConfig();

foreach ($allConfig as $propertyGroup => $properties) {
    echo "$propertyGroup:<br>";
    foreach ($properties as $key => $value) {
        echo "'$key': '$value'<br>";
    }
} */


//$request = new Request();
//print_r($request->data);



/* var_dump($_SERVER['REQUEST_METHOD']); */

//$cookie = new Cookie();
//$cookie->setCookie('name', 'Katya');
//print_r($cookie->getCookie());
