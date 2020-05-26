<?php

namespace App\Core;

use App\DAO\Database;

class Model {

    private $con;

    function __construct(){
        return $con = Database::getConnect();
    }

    
}