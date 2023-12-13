<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
$config = Config::getInstance();

function showConsig(array $configAll) 
{
    foreach($configAll as $conf) {

        $group = $conf['Group'];
        $value = $conf['value'];

        print_r("`$group`:");
        if (is_null($value)) {
            print_r("<br><span style='margin-left:20px'>NULL</span>");
        } else {
            foreach($value as $key=>$val) {
                print_r("<br><span style='margin-left:20px'>'$key':'$val'</span>");
            }
        }
        echo "<br><br>";
        
    }
}

showConsig([
    ['Group' => 'ConfigBD', 'value' => $config->getConfigBD()],
    ['Group' => 'ConfigUser', 'value' => $config->getConfigUser()],
    ['Group' => 'ConfigEnv', 'value' => $config->getConfigEnv()],
]);

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
