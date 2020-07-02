<?php

namespace App\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log {

    protected $logInfo;
    protected $logWarning;
    private $user;

    function __construct(){
        $this->user = $_SESSION['email'];

        $this->logInfo = new Logger('info');
        $this->logWarning = new Logger('warning');

        $logName = "logs/".date('Ymd').".log";

        $this->logWarning->pushHandler(new StreamHandler($logName, Logger::WARNING));
        $this->logInfo->pushHandler(new StreamHandler($logName, Logger::INFO));
    }
    
   
    public function setInfo($log) {
        
        $this->logInfo->info($this->user." ".$log);

    }


}