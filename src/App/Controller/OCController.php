<?php

namespace App\Controller;

use App\Model\OCModel;

class OCController {

    private $model;

    function __construct(){
        $this->model = new OCModel();
    }

    function create($data){
        
        return $this->model->create($data);
    }

    function read($data){
        
        return $this->model->read();
    }

    function getId($data){
        
        return $this->model->getId($data);
    }


    function update($data){

        return $this->model->update($data);
    }

    function delete($request){
        
        return $this->model->delete($request);
    }

}