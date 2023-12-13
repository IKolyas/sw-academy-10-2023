<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';


use app\Base\Config;

$config = Config::getInstance();
$data = Config::getInstance()->getData();


foreach ($data as $groups => $group) {
    echo '***' . $groups . '*** <br>';
    foreach ($group as $key => $value) {
        echo "'$key': '$value'<br>";
    }
    echo '<br>';
}
