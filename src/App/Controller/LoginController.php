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
        $_SESSION['id'] = $user['id'];
        $_SESSION['permissao'] = $user['permissao'];

        return $result;
    }

    function verificarLogado(){
        $result = $this->model->verificarLogado();
        return $result;
    }

    function deslogar(){
        session_destroy();
        return $result;
    }

}