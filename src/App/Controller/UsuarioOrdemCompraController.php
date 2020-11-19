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
    
    function readLimit($data){
        
        return $this->model->readLimit($data);
    }


    function filter($data){
        
        return $this->model->filter($data);
    }

    function filterForUser($data){
        
        return $this->model->filterForUser($data);
    }
    function readForUser($data){
        
        return $this->model->readForUser($data);
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

    function addUsers($request){

        $users = explode(",",$request['users']);
        $id_oc = $request['id'];

        foreach($users as $user){
            $data["id_usuario"] = $user;
            $data["id_ordem_compra"] = $id_oc;
            $this->create($data);
        }
        return['ok'];
    }

    function getUsersOC($request){

        return $this->model->getUsersOC($request);
    }

    

}