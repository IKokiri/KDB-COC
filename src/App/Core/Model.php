<?php

namespace App\Core;

use App\DAO\Database;

class Model {

    protected $conn;

    function __construct(){
        
        $this->conn = Database::getConnect();
        
    }

    
}