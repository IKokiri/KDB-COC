<?php

namespace App\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log {

    protected $logInfo;
    protected $logWarning;

    function __construct(){
        $this->logInfo = new Logger('info');
        $this->logWarning = new Logger('warning');

        $this->logWarning->pushHandler(new StreamHandler('coc.log', Logger::WARNING));
        $this->logInfo->pushHandler(new StreamHandler('coc.log', Logger::INFO));
    }
    
   
    public function setInfo($log) {

        $this->logInfo->info($log);

    }
       
    public function setWarning($log) {

        $this->logWarning->warning($log);

    }

}