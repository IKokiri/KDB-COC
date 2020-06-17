<?php

namespace App\Controller;

use App\Model\DocumentoModel as Model;
use App\Mail\Mail;
use App\Model\UsuarioOrdemCompraModel;
use Exception;

class DocumentoController {

    private $model;

    function __construct(){
        $this->model = new Model();
    }

    private function comunicar($oc,$documento,$operacao){
        $numeroOC = "";
        
        $data = ['id_ordem_compra'=>$oc];

        $usuOc = new UsuarioOrdemCompraModel();

        $result = $usuOc->dataMail($data);

        $arrayDestinos = $result['result_array'];

        $mail = new Mail(); 
        
        foreach($arrayDestinos as $destino){
            $numeroOC = $destino['numero'];
            $mail->destinatario($destino['email']);
        }
        
        $assunto = "OC {$numeroOC} Alterada";
        $corpo = "O documento {$documento} foi {$operacao}";

        $mail->send($assunto,$corpo);

    }

    function create($data){
     
        $files = $data['files'];

        foreach($files as $file){     
            
            $name = explode(".",$file['name']);
            $nome = $name[0];
            $extensao =  end($name);
            $nomeCompleto = $nome.".".$extensao;
            $path = "./src/docs/".$nomeCompleto;
            $file['extensao'] = $extensao;
            $file['path'] = $nomeCompleto;
            $data['nome'] = $nome;
            $data['extensao'] = $extensao;
            $data['path'] = $nomeCompleto;

            move_uploaded_file($file['tmp_name'], $path);
            $this->model->create($data);

            $this->comunicar($data["id_ordem_compra"],$nomeCompleto,"Adicionado");
            
        }
        return ['ok'];
    }

    function read($data){
        
        return $this->model->read();
    }
    

    function getId($data){
        
        return $this->model->getId($data);
    }

    function update($data){
        die;
        if(isset($data['files']['file0']['tmp_name'])){       
            $name = explode(".",$data['files']['file0']['name']);
            $nome = $name[0];
            $extensao =  end($name);
            $nomeCompleto = $nome.".".$extensao;
            $path = "./src/docs/".$nomeCompleto;
            $file['extensao'] = $extensao;
            $file['path'] = $nomeCompleto;
            $data['nome'] = $nome;
            $data['extensao'] = $extensao;
            $data['path'] = $nomeCompleto;
            
            move_uploaded_file($data['files']['file0']['tmp_name'], $path);

            $this->comunicar($data["id_ordem_compra"],$nomeCompleto,"Alterado");
        }
    
        return $this->model->update($data);
    }

    function delete($data){
        $result = $this->model->getId($data);
        $nomeCompleto = $result['result_array'][0]['path'];
        $id_ordem_compra = $result['result_array'][0]['id_ordem_compra'];
        $this->comunicar($id_ordem_compra,$nomeCompleto,"Removido");

        return $this->model->delete($data);
    }

}