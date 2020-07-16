<?php
use App\Controller\LoginController;

session_start();
require_once "./vendor/autoload.php";

$login = new LoginController();
$logado = $login->verificarLogado();
$dadosLogado = $logado['result_array'][0];
$modulos=[
    "DocumentoController"=>1,
    "DownloadDocumentoController"=>1,
    "LoginController"=>0,
    "OCController"=>1,
    "UsuarioController"=>1,
    "UsuarioOrdemCompraController"=>0
];


$request = $_REQUEST;
$request['files'] = $_FILES;

$class = $request['class'];
$method = $request['method'];

if(!$logado['count']){
    $class= "LoginController";
    $method= "getLogin";
}


if($modulos[$class] > $dadosLogado['permissao']){
    die("Sem permissão");
}

$namespace = "App\Controller\\".$class;
$params = $request;
$class = new $namespace;

$result = call_user_func_array(array($class, $method), array($params));

$result['user'] = $_SESSION['email'];

echo json_encode($result);

