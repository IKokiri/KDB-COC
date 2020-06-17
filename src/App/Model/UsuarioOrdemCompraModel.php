<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class UsuarioOrdemCompraModel extends Model{

    private $table = "`coc`.`usuario_ordem_compra`";
    private $model = "UsuarioOrdemCompraModel";
    private $usuario = "USER";

    function read(){
        
        $sql = "SELECT usu_ord.id,ord.numero,usu.email FROM $this->table usu_ord
        INNER JOIN coc.ordem_compra ord
        on usu_ord.id_ordem_compra = ord.id
        INNER JOIN coc.usuarios usu
        on usu_ord.id_usuario = usu.id";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readForUser(){
        
        $sql = "SELECT oco.numero,doc.nome,doc.path,doc.extensao,doc.id as id_documento from `coc`.`usuario_ordem_compra` usu_oco
        INNER JOIN `coc`.`usuarios` usu
            on usu_oco.id_usuario = usu.id
        INNER JOIN `coc`.`ordem_compra` oco
            on usu_oco.id_ordem_compra = oco.id
        INNER JOIN `coc`.`documentos` doc
            on oco.id = doc.id_ordem_compra
            WHERE usu.email = '".$_SESSION['email']."'";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readForUser) os registros");

        return $result;

    }

    function dataMail($data){

        $this->populate($data);

        $sql = "SELECT usu.email,ord.numero FROM
            coc.usuario_ordem_compra usuoc
                INNER JOIN coc.usuarios usu
                on usuoc.id_usuario = usu.id
                INNER JOIN coc.ordem_compra ord
                on usuoc.id_ordem_compra = ord.id
            WHERE id_ordem_compra = :id_ordem_compra";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id_ordem_compra', $this->id_ordem_compra, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model dataMail) o registro $this->id_ordem_compra");

        return $result;
    }
 
    function getId($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM ".$this->table." 
        WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model getId) o registro $this->id");

        return $result;
    }


    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`id_usuario`,
                    `id_ordem_compra`,
                    `criado`)
                    VALUES
                    (:id_usuario,
                    :id_ordem_compra,
                    curtime())";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);
        $query->bindValue(':id_ordem_compra', $this->id_ordem_compra, PDO::PARAM_STR);
        

        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $sql = "UPDATE ".$this->table." 
                SET
                `id_usuario` = :id_usuario,
                `id_ordem_compra` = :id_ordem_compra,                
                `editado` = curtime()
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);        
        $query->bindValue(':id_ordem_compra', $this->id_ordem_compra, PDO::PARAM_STR);
      
        $result = Database::executa($query);   

        $this->log->setInfo("Atualizaou ($this->model update) o registro $this->id");

        return $result;
    }

    function delete($data){

        $this->populate($data);

        $sql = "DELETE FROM ".$this->table." 
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Removeu ($this->model delete) o registro $this->id");
        
        return $result;
    }

}

