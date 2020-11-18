<?php
use App\Controller\LoginController;
use App\Core\Permissoes;
session_start();
error_reporting(0);
require_once "./vendor/autoload.php";
if($_REQUEST['method'] == "deslogar"){
    session_destroy();
    
    echo json_encode(["ok"]);
    die;
}
$login = new LoginController();
$permissoes = new Permissoes();
$telas = "";
$class = "";
$method = "";
$emailLogado = "";
$request = $_REQUEST;

/**
 * captura exceção de arquivo grande
 */
if ($_SERVER['CONTENT_LENGTH'] > 18380000) {
     $result['MSN']['errorInfo'][1] = "ArqGrande";
     echo json_encode($result);
     die;
}
$logado = $login->verificarLogado();

$dadosLogado = $logado['result_array'][0];

if(!$logado['count']){
    $class= "LoginController";
    $method= "getLogin";
}else{
    $telas = $permissoes->telasUsuario($dadosLogado);    
    $emailLogado = $dadosLogado['email'];
    $class = $request['class'];
    $method = $request['method'];

    $result['user'] = $_SESSION['email'];
}
$permissaoClassMethod = $permissoes->permissaoUsuario($class,$method,$dadosLogado);

if(!$permissaoClassMethod){
    die("sem permissao para este acesso");
}

$request['files'] = $_FILES;

$namespace = "App\Controller\\".$class;
   
$obj = new $namespace;

$params = $request;

$result = call_user_func_array(array($obj, $method), array($params));

$result['telas'] = $telas;
$result['emailLogado'] = $emailLogado;

echo json_encode($result);

