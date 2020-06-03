<?php

require_once "./vendor/autoload.php";

$request = $_REQUEST;

$class = $request['class'];
$method = $request['method'];
$namespace = "App\Controller\\".$class;
$params = $request;
$class = new $namespace;

$result = call_user_func_array(array($class, $method), array($params));

echo json_encode($result);
