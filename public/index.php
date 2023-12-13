<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
// $configData = include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php';
// // use config\config as config;
// print_r($configData);

use app\Singleton\Config;

// $config = Config::getInstance();
$array = Config::getInstance()->getData();
print_r($array);

// echo $_SERVER['DOCUMENT_ROOT'];

// foreach ($array as $row) {
//     print_r($row . "\r\n");
//     }




// use app\Example\Models\ExampleModel;
// use app\Example\Models\TestModel;

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

// echo 'hello bro!';

// echo phpinfo();
