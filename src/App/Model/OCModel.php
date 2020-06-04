<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class OCModel extends Model{

    private $table = "`coc`.`ordem_compra`";
    private $model = "OCModel";
    private $usuario = "USER";

    function read(){
        
        $sql = "SELECT * FROM ".$this->table;

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

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
                    (`numero`,
                    `criado`)
                    VALUES
                    (:numero,
                    curtime())";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);

        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $sql = "UPDATE ".$this->table." 
                    SET
                    `numero` = :numero
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', $this->numero, PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);

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

