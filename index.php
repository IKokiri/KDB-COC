<?php
session_start();
require_once "./vendor/autoload.php";

// $_SESSION['email'] = "p.augusto@kuttner.com.br";$_SESSION['senha'] = "1234567890";
// $_SESSION['email'] = "l.mendes@kuttner.com.br";$_SESSION['senha'] = "1234";

$request = $_REQUEST;
$request[] = $_FILES;

$class = $request['class'];
$method = $request['method'];
$namespace = "App\Controller\\".$class;
$params = $request;
$class = new $namespace;

$result = call_user_func_array(array($class, $method), array($params));

echo json_encode($result);
