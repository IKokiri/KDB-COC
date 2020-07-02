<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class DocumentoModel extends Model{

    private $table = "`coc`.`documentos`";
    private $model = "DocumentoModel";
    private $usuario = "USER";

    function read(){
        
        $sql = "SELECT doc.id,doc.nome,doc.path,ord.numero,doc.extensao FROM $this->table doc
                    INNER JOIN coc.ordem_compra ord
                        on doc.id_ordem_compra = ord.id";

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
                    (`nome`,
                    `extensao`,
                    `path`,
                    `id_ordem_compra`,
                    `criado`)
                    VALUES
                    (:nome,
                    :extensao,
                    :path,
                    :id_ordem_compra,
                    curtime())";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        $query->bindValue(':extensao', $this->extensao, PDO::PARAM_STR);
        $query->bindValue(':id_ordem_compra', $this->id_ordem_compra, PDO::PARAM_STR);
        $query->bindValue(':path', $this->path, PDO::PARAM_STR);
        

        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $path = "";
        
        if($this->path){
            $path = "`extensao` = :extensao,`path` = :path,`nome` = :nome,  ";
        }

        $sql = "UPDATE ".$this->table." 
                SET
                `id` = :id,              
                `id_ordem_compra` = :id_ordem_compra,
                ".$path."
                `editado` = curtime()
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);

        if($this->path){
            $query->bindValue(':extensao', $this->extensao, PDO::PARAM_STR);
            $query->bindValue(':path', $this->path, PDO::PARAM_STR);
            $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);
        }
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':nome', $this->nome, PDO::PARAM_STR);        
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
