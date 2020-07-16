<?php

namespace App\DAO;

class InfoDB {

    private $host = "localhost";
    private $database = "coc";
    private $user = "root";
    private $password = "LDeveloper#123d";

    function getHost(){
        return $this->host;
    }
    
    function getDatabase(){
        return $this->database;
    }

    function getUser(){
        return $this->user;
    }
    
    function getPassword(){
        return $this->password;
    }

}
