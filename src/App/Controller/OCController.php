<?php

namespace App\Controller;

use App\Model\OCController_Model;

class OCController {

    private $model;
    private $numero;
    
    function __construct(){
        $this->model = new OCController_Model();
    }


    function create(){

    }

    function read(){
        return $this->model->get();
    }

    function update(){

    }

    function delete(){

    }
}