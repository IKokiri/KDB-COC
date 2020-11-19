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
        $corpo = "<b>*Este &eacute; um e-mail autom&aacute;tico, n&atilde;o responda.</b><br/><br/>";
        $corpo .= "Documentos {$operacao}: {$documento}<br/>";
        $corpo .= "Acesse <a href='http://10.0.0.252:8090/KDB-COC/front/'>Sistema OCs</a> para mais informa&ccedil;&otilde;es.<br/><br/>";
        $corpo .= "<b>*Este &eacute; um e-mail autom&aacute;tico, n&atilde;o responda.</b><br/>";

        $mail->send($assunto,$corpo);

    }

    function create($data){
        
        mkdir('./src/docs/'.$data['id_ordem_compra'].'/', 0777, true);

        $files = $data['files'];
            $arqNomes = "<br><br>";

        foreach($files as $file){  

            $name = explode(".",$file['name']);
           
            $extensao =  end($name);
            unset($name[count($name)-1]);
          
            $nome = implode(".",$name);
            $nomeCompleto = $nome.".".$extensao;
            $arqNomes .= $nomeCompleto."<br>";
            $path = "./src/docs/".$data['id_ordem_compra']."/".$nomeCompleto;
            $file['extensao'] = $extensao;
            $file['path'] = $nomeCompleto;
            $data['nome'] = $nome;
            $data['extensao'] = $extensao;
            $data['path'] = $nomeCompleto;

            if(file_exists($path)){
                $result['MSN']['errorInfo'][1] = "arqDup";
                $result['MSN']['errorInfo'][2] .= $nomeCompleto.",";
                continue;
            }

            move_uploaded_file($file['tmp_name'], $path);
            
            $this->model->create($data);

            // $this->comunicar($data["id_ordem_compra"],$nomeCompleto,"Adicpdocumionado");
            
        }
        if($data['notificar'] == "true"){
            
            $this->comunicar($data["id_ordem_compra"],$arqNomes,"Adicionados");
        }

        
        return $result;
    }

    function read($data){
        
        return $this->model->read();
    }
    

    function getId($data){
        
        return $this->model->getId($data);
    }


    function filter($data){
        
        return $this->model->filter($data);
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

            $this->comunicar($data["id_ordem_compra"],$nomeCompleto,"Alterados");
        }
    
        return $this->model->update($data);
    }

    function delete($data){
        $result = $this->model->getId($data);
    
        $nomeCompleto = $result['result_array'][0]['path'];
        $id_ordem_compra = $result['result_array'][0]['id_ordem_compra'];
        $this->comunicar($id_ordem_compra,$nomeCompleto,"Removidos");
        /**
         * renomeia o arquivo
         */
        rename("./src/docs/".$id_ordem_compra."/".$nomeCompleto, "./src/docs/".$id_ordem_compra."/".date('YmdHis').$nomeCompleto);

        return $this->model->delete($data);
    }

}