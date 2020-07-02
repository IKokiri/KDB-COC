<?php

session_start();
require_once "./vendor/autoload.php";

$request = $_REQUEST;
$request['files'] = $_FILES;

$class = $request['class'];
$method = $request['method'];
$namespace = "App\Controller\\".$class;
$params = $request;
$class = new $namespace;

$result = call_user_func_array(array($class, $method), array($params));

$result['user'] = $_SESSION['email'];

echo json_encode($result);

