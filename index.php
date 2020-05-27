<?php

require_once "./vendor/autoload.php";

use App\Controller\OCController;

$oc = new OCController();


$o = $oc->read();

echo $o;