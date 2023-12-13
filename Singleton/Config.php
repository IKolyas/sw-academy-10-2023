<?php

namespace app\Singleton;


class Config {
    
    // $configData = include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php';
    
    private ?array $configData = null;
    private ?string $dbHost = null;
    private ?string $dbPort = null;

    
    protected static self|null $instance = null;
    
    final private function __construct(){
        $date = include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php'; 

        $this->configData = $date['dbInfo'];
        // $this->configData = $date['dbInfo']['port'];
        // $this->configData = $date['adminInfo']['login'];
        // $this->configData = $date['adminInfo']['password'];
        // $this->configData = $date['adminInfo']['email'];
        // $this->configData = $date['adminInfo']['name'];
        // $this->configData = $date['adminInfo']['surname'];
        // $this->configData = $date['envInfo']['APP_ENV'];


        
    }
    final protected function __clone(){}
    final public function __wakeup(){}

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function getData() {
        return $this->configData; 
    }

    public function setData() {
        
    }
}



// namespace app\Singleton;

// class Config {
//     protected static $instance;
//     private ?string $dbHost = 'arr';
//     private ?string $dbPort = '3333';

//         private function __construct() {  
//             $this->setConfig([
//                 'host' => null,
//                 'port' => null,
//             ]);      
//     }

//     public function setConfig(array $dbConfig): void
//     {
//         $this->dbHost = !empty($dbConfig['host']) ? $dbConfig['host'] : null;
//         $this->dbPort = !empty($dbConfig['port']) ? $dbConfig['port'] : null;
//     }

//     public static function getInstance(): Config
//     {
//         if (is_null(static::$instance)) {
//             static::$instance = new static();
//         }

//         return static::$instance;
//     }

//     public function getDbData() {
//         return [
//             'host' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
//             'port' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
//         ];
//     }

//     public function getEnvData() {
//         return [
//             'database' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
//             'user' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
//             'password' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
//         ];
//     }

//     public function getAdminData() {
//         return [
//             include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
            // 'password' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
            // 'email' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
            // 'name' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
            // 'surname' => include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php',
    //     ];
    // }
 
    // private function __clone() {
    // }

    // private function __wakeup() {
    // }    
// }


// class Database extends Singleton
// {
//     public function connect()
//     {
//         // ...
//     }
// }

// class Logger extends Singleton
// {
//     private $connection;

//     public function settings($connection = null)
//     {
//         $this->connection = $connection ?? '/var/logs/filename.log';
//     }

//     public function error(string $message)
//     {
//         // ...
//     }

//     public function warn(string $message)
//     {
//         // ...
//     }
// }


?>