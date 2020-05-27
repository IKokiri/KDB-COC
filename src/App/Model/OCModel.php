<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class OCModel extends Model{

    function get(){

        $sql = "select * from ordem_compra where id = :id";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id', 1, PDO::PARAM_STR);

        $result = Database::executa($query);   

        echo json_encode($result);
    }


    function save(){

        $sql = "INSERT INTO `coc`.`ordem_compra`
                    (`numero`)
                    VALUES
                    (:numero);";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', 432, PDO::PARAM_STR);

        $result = Database::executa($query);   

        echo json_encode($result);
    }


    function update(){

        $sql = "UPDATE `coc`.`ordem_compra`
                    SET
                    `numero` = :numero
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':numero', 123123123123, PDO::PARAM_STR);
        $query->bindValue(':id', 1, PDO::PARAM_STR);

        $result = Database::executa($query);   

        echo json_encode($result);
    }

    function delete(){

        $sql = "DELETE FROM `coc`.`ordem_compra`
                    WHERE `id` = :id;";

        $query = $this->conn->prepare($sql);
        
        $query->bindValue(':id', 1, PDO::PARAM_STR);

        $result = Database::executa($query);   

        echo json_encode($result);
    }
}

