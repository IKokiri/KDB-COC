<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class DocumentoModel extends Model{

    private $table = "`documentos`";
    private $model = "DocumentoModel";
    private $usuario = "USER";

    function read(){
        
        $sql = "SELECT doc.id,doc.nome,doc.path,ord.numero,doc.extensao,ord.id as id_oc FROM $this->table doc
                    INNER JOIN ordem_compra ord
                        on doc.id_ordem_compra = ord.id";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readLimit($data){
        
        $this->populate($data);

        $sql = "SELECT doc.id,doc.nome,doc.path,ord.numero,doc.extensao,ord.id as id_oc FROM $this->table doc
        INNER JOIN ordem_compra ord
            on doc.id_ordem_compra = ord.id limit :pagini,:pagfim";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':pagini', (int)$this->pagini, PDO::PARAM_INT);
        $query->bindValue(':pagfim', (int)$this->pagfim, PDO::PARAM_INT);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model readLimit) os registros");

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

    function filter($data){
        
        $this->populate($data);

        $sql = "SELECT doc.id,doc.nome,doc.path,ord.numero,doc.extensao FROM $this->table doc
    INNER JOIN ordem_compra ord
        on doc.id_ordem_compra = ord.id
        WHERE nome LIKE :nome or path LIKE :path or numero LIKE :numero or extensao LIKE :extensao";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':nome', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':path', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':numero', "%".$this->term."%", PDO::PARAM_STR);
        $query->bindValue(':extensao', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Filtrou ($this->model getId) o registro $this->id");

        return $result;
    }
    

    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`nome`,
                    `extensao`,
                    `path`,
                    `id_ordem_compra`)
                    VALUES
                    (:nome,
                    :extensao,
                    :path,
                    :id_ordem_compra)";

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
            $path = "`extensao` = :extensao,`path` = :path,`nome` = :nome  ";
        }

        $sql = "UPDATE ".$this->table." 
                SET
                `id` = :id,              
                `id_ordem_compra` = :id_ordem_compra,
                ".$path."
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

