<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class UsuarioModel extends Model{

    private $table = "`coc`.`usuarios`";
    private $model = "UsuarioModel";

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

    function getLogin($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM coc.usuarios
        WHERE email = :email and senha = :senha";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("$this->email Buscou ($this->model getLogin)");

        return $result;
    }
    

    function create($data){
        
        $this->populate($data);
        
        $sql = "INSERT INTO ".$this->table." 
                    (`email`,
                    `senha`,
                    `permissao`,
                    `criado`)
                    VALUES
                    (:email,
                    :senha,
                    :permissao,
                    curtime())";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':email', $this->email, PDO::PARAM_STR);
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);
        $query->bindValue(':permissao', $this->permissao, PDO::PARAM_STR);
        
        $result = Database::executa($query); 
          
        $this->log->setInfo("Criou ($this->model create) o registro ". $this->conn->lastInsertId());

        return $result;
    }

    function update($data){

        $this->populate($data);

        $sql = "UPDATE ".$this->table." 
                SET
                `email` = :email,
                `senha` = :senha,
                `permissao` = :permissao,                 
                `editado` = curtime()
                WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_STR);
        $query->bindValue(':email', $this->email, PDO::PARAM_STR);        
        $query->bindValue(':permissao', $this->permissao, PDO::PARAM_STR);  
        $query->bindValue(':senha', $this->senha, PDO::PARAM_STR);
      
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

    function verificarLogado(){

        $this->populate($data);

        $sql = "SELECT * FROM coc.usuarios
        WHERE email = :email and senha = :senha and id = :id and permissao = :permissao";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
        $query->bindValue(':senha', $_SESSION['senha'], PDO::PARAM_STR);
        $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
        $query->bindValue(':permissao', $_SESSION['permissao'], PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("$this->email Buscou ($this->model verificarLogado)");

        return $result;

    }

}

