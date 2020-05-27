<?php

namespace App\Controller;

use App\Model\OCModel;

class OCController {

    private $model;
    private $numero;
    
    function __construct(){
        $this->model = new OCModel();
    }


    function create(){

    }

    function read(){
        // return $this->model->get();
        // return $this->model->save();
        // return $this->model->update();
        // return $this->model->delete();
    }

    function update(){

    }

    function delete(){

    }
}