<?php

namespace App\Controller;

use App\Model\UsuarioOrdemCompraModel as Model;

class UsuarioOrdemCompraController {

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


    function filter($data){
        
        return $this->model->filter($data);
    }

    function filterForUser($data){
        
        return $this->model->filterForUser($data);
    }
    function readForUser($data){
        
        return $this->model->readForUser();
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