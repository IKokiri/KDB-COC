<?php

namespace App\Core;

use App\DAO\Database;
use App\Core\Log;

class Model {

    protected $conn;
    protected $log;
    
    function __construct(){
        
        $this->conn = Database::getConnect();
        $this->log = new Log();
    }   
    
}