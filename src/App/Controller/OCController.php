<?php

namespace App\Controller;

use App\Model\OCModel;

class OCController {

    private $model;
    

    function __construct(){
        $this->model = new OCModel();
    }

    function create($data){

        return $this->model->save($data);
    }

    function read($request){
        
        return $this->model->get();
    }

    function update(){

        return $this->model->update();
    }

    function delete(){
        
        return $this->model->delete();
    }

}