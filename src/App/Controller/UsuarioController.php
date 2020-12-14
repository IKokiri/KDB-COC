<?php

namespace App\Controller;

use App\Model\UsuarioModel as Model;

class UsuarioController {

    private $model;

    function __construct(){
        $this->model = new Model();
    }

    function create($data){

        return $this->model->create($data);
    }
    
    function read($data){
        
        return $this->model->read();
    }
    function readUserOc($data){
        
        return $this->model->readUserOc($data);
    }
    function readLimit($data){
        
        return $this->model->readLimit($data);
    }

    function filter($data){
        
        return $this->model->filter($data);
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