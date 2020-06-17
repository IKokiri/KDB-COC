<?php


session_start();
require_once "./vendor/autoload.php";

$_SESSION['email'] = "p.augusto@kuttner.com.br";
$_SESSION['senha'] = "1234567890";
$_SESSION['id'] = "1";

// $_SESSION['email'] = "l.mendes@kuttner.com.br";
// $_SESSION['senha'] = "1234";
// $_SESSION['id'] = "4";

$request = $_REQUEST;
$request['files'] = $_FILES;

$class = $request['class'];
$method = $request['method'];
$namespace = "App\Controller\\".$class;
$params = $request;
$class = new $namespace;

$result = call_user_func_array(array($class, $method), array($params));

echo json_encode($result);

