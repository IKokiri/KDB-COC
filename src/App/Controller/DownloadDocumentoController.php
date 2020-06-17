<?php

namespace App\Controller;

use App\Model\DownloadDocumentoModel as Model;
use Exception;

class DownloadDocumentoController {

    private $model;

    function __construct(){
        $this->model = new Model();
    }

    function add($data){
        
        return $this->model->add($data);
    }

    function getInfo($data){
        
        return $this->model->getInfo($data);
    }
}