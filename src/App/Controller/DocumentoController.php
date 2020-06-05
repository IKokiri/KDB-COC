<?php

namespace App\Controller;

use App\Model\DocumentoModel as Model;

class DocumentoController {

    private $model;

    function __construct(){
        $this->model = new Model();
    }

    function create($data){

        $nome = date("ymdhis");        
        $name = explode(".",$data[0]['file']['name']);
        $extensao =  end($name);
        
        $nomeCompleto = $nome.".".$extensao;
        $path = "./src/docs/".$nomeCompleto;
        
        $data['extensao'] = $extensao;
        $data['path'] = $nomeCompleto;
        
        move_uploaded_file($data[0]['file']['tmp_name'], $path);

        return $this->model->create($data);
    }

    function read($data){
        
        return $this->model->read();
    }
    

    function getId($data){
        
        return $this->model->getId($data);
    }

    function update($data){
      
        if(isset($data[0]['file']['tmp_name'])){
            $nome = date("ymdhis");        
            $name = explode(".",$data[0]['file']['name']);
            $extensao =  end($name);
            
            $nomeCompleto = $nome.".".$extensao;
            $path = "./src/docs/".$nomeCompleto;
            
            $data['extensao'] = $extensao;
            $data['path'] = $nomeCompleto;
            
            move_uploaded_file($data[0]['file']['tmp_name'], $path);
        }
    
        return $this->model->update($data);
    }

    function delete($request){
        
        return $this->model->delete($request);
    }

}