<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class UsuarioModel extends Model{

    private $table = "`usuarios`";
    private $model = "UsuarioModel";

    function read(){
        
        $sql = "SELECT * FROM ".$this->table." ORDER BY email asc";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        $this->log->setInfo("Buscou ($this->model read) os registros");

        return $result;

    }

    function readLimit($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM ".$this->table." ORDER BY email asc limit :pagini,:pagfim";

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

        $sql = "SELECT * FROM ".$this->table." 
        WHERE `email` LIKE :email;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':email', "%".$this->term."%", PDO::PARAM_STR);

        $result = Database::executa($query);   

        $this->log->setInfo("Filtrou ($this->model getId) o registro");

        return $result;
    }


    function getLogin($data){
        
        $this->populate($data);

        $sql = "SELECT * FROM usuarios
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
                    `permissao`)
                    VALUES
                    (:email,
                    :senha,
                    :permissao)";

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
                `permissao` = :permissao
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

        $sql = "SELECT * FROM usuarios
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

