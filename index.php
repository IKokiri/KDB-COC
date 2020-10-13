<?php
use App\Controller\LoginController;
use App\Core\Permissoes;
session_start();

require_once "./vendor/autoload.php";

$login = new LoginController();
$permissoes = new Permissoes();
$telas = "";
$class = "";
$method = "";
$request = $_REQUEST;

$logado = $login->verificarLogado();

$dadosLogado = $logado['result_array'][0];

if(!$logado['count']){
    $class= "LoginController";
    $method= "getLogin";
}else{
    $telas = $permissoes->telasUsuario($dadosLogado);    
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

echo json_encode($result);

