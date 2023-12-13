<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use app\Base\Config;
$config = Config::getInstance();

function showConfigAll(array $configAll) 
{
    foreach($configAll as $nameGroup=>$conf) {

        $group = $nameGroup;
        $value = $conf;

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


$config->setConfig('db', ['host' => 'Ghost','port' => '3307']);

showConfigAll($config->getConfigAll());
echo '<br>';
showConfigAll($config->getConfigEnv());


echo phpinfo();
