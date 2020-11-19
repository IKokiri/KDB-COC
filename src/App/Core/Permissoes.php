<?php

namespace App\Core;
use PDO;

class Permissoes {

    protected $conn;
    protected $log;
    private $modulos;
    private $telas;

    function __construct(){
        $this->modulos=[
            "DocumentoController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'comunicar'=>1,
                        'filter'=>1,
                        'readLimit'=>1
                    ]
            ],
            "DownloadDocumentoController"=>[
                'permissao' => 0,
                'funcoes' => [
                        'add'=>0,
                        'getInfo'=>0
                    ]
            ],
            "LoginController"=>[
                'permissao' => 0,
                'funcoes' => [
                        'getLogin'=>0,
                        'verificarLogado'=>1,
                        'deslogar'=>1
                    ]
            ],
            "OCController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'filter'=>1,
                        'readLimit'=>1
                    ]
            ],
            "UsuarioController"=>[
                'permissao' => 1,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'filter'=>1,
                        'readLimit'=>1
                    ]
            ],
            "UsuarioOrdemCompraController"=>[
                'permissao' => 0,
                'funcoes' => [
                        'create'=>1,
                        'read'=>1,
                        'getId'=>1,
                        'update'=>1,
                        'delete'=>1,
                        'readForUser'=>0,
                        'filter'=>1,
                        'filterForUser'=>0,
                        'addUsers'=>1,
                        'getUsersOC'=>1,
                        'readLimit'=>1
                    ]
            ],
            "Gosth"=>[
                'permissao' => 0,
                'funcoes' => [
                        'gosth'=>0
                    ]
            ],
        ];

        $this->telas = [

            [
                'nome'=>"Usuários",
                'caminho'=>"usuario.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Ordem de Compra",
                'caminho'=>"ordem_compra.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Usuário X Ordem Compra",
                'caminho'=>"usuario_ordem_compra.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Documentos",
                'caminho'=>"documentos.php",
                'permissao'=>1
            ],
            [
                'nome'=>"Download Documentos",
                'caminho'=>"",
                'permissao'=>1
            ],
            [
                'nome'=>"Login",
                'caminho'=>"",
                'permissao'=>1
            ],
            [
                'nome'=>"Visualizar OCs",
                'caminho'=>"visualizacao_ocs.php",
                'permissao'=>0
            ],
            
        ];
        
    }   
    /**
     * RETORNA AS TELAS QUE O USUÁRIO TEM PERMISSÃO DE ACESSO
     */
    function telasUsuario($dadosUsuario){  

        
        $t = [];
        
        $telas = $this->telas;
 
        foreach($telas as $tela){
            
            $tel = $this->permissao($tela,$dadosUsuario);
           
            if($tel){
                $t['telas'][] = $tela;
            }

        }

        return $t;
    }

    function permissaoUsuario($class,$method,$dadosUsuario){
        
        $permissaoClass = $this->modulos[$class]['permissao'];
        $permissaoMethod = $this->modulos[$class]['funcoes'][$method];
        $permissaoUser = $dadosUsuario['permissao'];

        $key = array_key_exists($method, $this->modulos[$class]['funcoes']);
      
      
        if($key && $permissaoUser >= $permissaoClass && $permissaoUser >= $permissaoMethod){
            return true;
        }
        
        return false;
        

    }

    /**
     * verifica se a permissão do usuário é equivalente ao acesso
     */
    private function permissao($tela,$dadosUsuario){
        
        if($dadosUsuario['permissao'] >= $tela['permissao']){
            return $tela;
        }

        return false;

    }
    
}