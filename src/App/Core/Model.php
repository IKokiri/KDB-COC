<?php

namespace App\Core;

use App\DAO\Database;
use App\Core\Log;
use App\Core\Auth;
use PDO;

class Model {

    protected $conn;
    protected $log;
    
    function __construct(){
        
        $this->conn = Database::getConnect();
        $this->log = new Log();
        
        $auth = $this->auth();
        if(!$auth){
            die("É necessário entrar");
        }
    }   

    function populate($object)
    {
        foreach ($object as $key => $attrib) {
            $this->$key = $attrib;
        }
    }

    function auth(){    

        $sql = "SELECT * FROM usuarios 
        WHERE `email` = :email and `senha` = :senha;";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
        $query->bindValue(':senha', $_SESSION['senha'], PDO::PARAM_STR);

        $result = Database::executa($query);   

        $r = $result['result_array'][0];
        
        if($r['email'] == $_SESSION['email'] && $r['senha'] == $_SESSION['senha']){
            return true;
        }else{
            return false;
        }
        
    
    }
    
}