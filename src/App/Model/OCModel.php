<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class OCModel extends Model{

    function get(){
        
        $sql = "SELECT * FROM `coc`.`ordem_compra`";

        $query = $this->conn->prepare($sql);

        $result = Database::executa($query);   

        return $result;
    }

    function save($data){

        $sql = "INSERT INTO `coc`.`ordem_compra`
                    (`numero`,
                    `criado`)
                    VALUES
                    (:numero,
                    curtime())";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', 12, PDO::PARAM_STR);

        $result = Database::executa($query);   

        return $result;
    }

    function update($data){

        $sql = "UPDATE `coc`.`ordem_compra`
                    SET
                    `numero` = :numero
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', 123123123123, PDO::PARAM_STR);
        $query->bindValue(':id', 1, PDO::PARAM_STR);

        $result = Database::executa($query);   

        return $result;
    }

    function delete($id){

        $sql = "DELETE FROM `coc`.`ordem_compra`
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', 1, PDO::PARAM_STR);

        $result = Database::executa($query);   
        
        return $result;
    }

}

