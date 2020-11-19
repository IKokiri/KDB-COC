<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class UsuarioOrdemCompraModel extends Model{

    private $table = "`usuario_ordem_compra`";
    private $model = "UsuarioOrdemCompraModel";
    private $usuario = "USER";

    function read(){
        
        $sql = "SELECT ord.numero,usu.email,usu_ord.id_usuario,usu_ord.id_ordem_compra FROM $this->table usu_ord
        INNER JOIN ordem_compra ord
        on usu_ord.id_ordem_compra = ord.id
        INNER JOIN usuarios usu
        on usu_ord.id_usuario = usu.id";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readForUser(){
        
        $sql = "SELECT oco.numero,oco.id as id_oc,doc.nome,doc.path,doc.extensao,doc.id as id_documento from `usuario_ordem_compra` usu_oco
        INNER JOIN `usuarios` usu
            on usu_oco.id_usuario = usu.id
        INNER JOIN `ordem_compra` oco
            on usu_oco.id_ordem_compra = oco.id
        INNER JOIN `documentos` doc
            on oco.id = doc.id_ordem_compra
            WHERE usu.email = '".$_SESSION['email']."'";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readForUser) os registros");

        return $result;

    }

    function filterForUser($data){
        
        $this->populate($data);
        
        $sql = "SELECT oco.numero,doc.nome,doc.path,doc.extensao,doc.id as id_documento from `usuario_ordem_compra` usu_oco
        INNER JOIN `usuarios` usu
            on usu_oco.id_usuario = usu.id
        INNER JOIN `ordem_compra` oco
            on usu_oco.id_ordem_compra = oco.id
        INNER JOIN `documentos` doc
            on oco.id = doc.id_ordem_compra
        WHERE usu.email = '".$_SESSION['email']."' and (numero LIKE :numero or nome LIKE :nome or path LIKE :path or extensao LIKE :extensao)";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':numero', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':nome', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':path', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':extensao', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readForUser) os registros");

        return $result;

    }

    

    function dataMail($data){

        $this->populate($data);

        $sql = "SELECT usu.email,ord.numero FROM
            usuario_ordem_compra usuoc
                INNER JOIN usuarios usu
                on usuoc.id_usuario = usu.id
                INNER JOIN ordem_compra ord
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
        WHERE `id_usuario` = :id_usuario and `id_ordem_compra` = :id_ordem_compra;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id_usuario', $this->idusuario, PDO::PARAM_STR);
        $query->bindValue(':id_ordem_compra', $this->idordemcompra, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model getId) o registro $this->id");

        return $result;
    }
 
    function getUsersOC($data){
        
        $this->populate($data);

        $sql = "SELECT id_usuario FROM ".$this->table." 
        WHERE `id_ordem_compra` = :id_ordem_compra;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id_ordem_compra', $this->id, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model getUsersOC) o registro $this->id");

        return $result;
    }

    function filter($data){
        
        $this->populate($data);

        $sql = "SELECT ord.numero,usu.email,usu_ord.id_usuario,usu_ord.id_ordem_compra FROM $this->table usu_ord
        INNER JOIN ordem_compra ord
        on usu_ord.id_ordem_compra = ord.id
        INNER JOIN usuarios usu
        on usu_ord.id_usuario = usu.id
        WHERE numero LIKE :numero or email LIKE :email";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':numero', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':email', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Filtrou ($this->model getId) o registro");

        return $result;
    }


    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`id_usuario`,
                    `id_ordem_compra`)
                    VALUES
                    (:id_usuario,
                    :id_ordem_compra)";

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
                `id_ordem_compra` = :id_ordem_compra
                WHERE `id_usuario` = :idusuario and `id_ordem_compra` = :idordemcompra;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);        
        $query->bindValue(':id_ordem_compra', $this->id_ordem_compra, PDO::PARAM_STR);
        $query->bindValue(':idusuario', $this->idusuario, PDO::PARAM_STR);        
        $query->bindValue(':idordemcompra', $this->idordemcompra, PDO::PARAM_STR);
      
        $result = Database::executa($query);   

        $this->log->setInfo("Atualizaou ($this->model update) o registro $this->id");

        return $result;
    }

    function delete($data){

        $this->populate($data);
        
        $sql = "DELETE FROM ".$this->table." 
                    WHERE `id_usuario` = :id_usuario and id_ordem_compra = :id_ordem_compra;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id_usuario', $this->idusuario, PDO::PARAM_STR);
        $query->bindValue(':id_ordem_compra', $this->idordemcompra, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Removeu ($this->model delete) o registro $this->id");
        
        return $result;
    }

}

