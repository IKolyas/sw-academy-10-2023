<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
$config = Config::getInstance();

print_r($config->getConfigBD());
print_r('<br>');
print_r($config->getConfigUser());

print_r('<br>');
print_r('<br>');

$config->setConfigBD([]);
print_r($config->getConfigBD());
print_r('<br>');
print_r($config->getConfigUser());

//use app\Example\Config\Config;
//use app\Example\Models\ExampleModel;
//use app\Example\Models\TestModel;

//$config = Config::getInstance();
//$config->setConfig(['host' => 'localhost', 'port' => '3306']);
//
//print_r($config->getDbData());
//$modelTest1 = new ExampleModel(1);

//$modelTest2 = new ExampleModel(2);

//var_dump($modelTest1->getDbData()->getDbData());
//echo '<br>';
//var_dump($modelTest2->getDbData()->getDbData());

//$request = new app\Example\Requests\ExampleRequest();
//print_r($request->config->getDbData());
//die();

//echo 'hello bro!';

echo phpinfo();
