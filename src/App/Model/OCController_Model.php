<?php

namespace App\Model;

use App\Core\Model;

class OCController_Model extends Model{

    function get(){

        return $sql = "select * from ordem_compra";


    }
}

