<?php

namespace App\Controller;

use App\Model\UsuarioModel as Model;
use Exception;

class LoginController {

    private $model;

    function __construct(){
        $this->model = new Model();
    }

    function getLogin($data){
        
        $result = $this->model->getLogin($data);
        $user = $result['result_array'][0];
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['senha'] = $user['senha'];
        $_SESSION['id'] = $user['id'];;

        return $result;
    }

}