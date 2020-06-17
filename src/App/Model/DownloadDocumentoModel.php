<?php

namespace App\Model;

use App\DAO\Database;
use App\Core\Model;
use PDO;


class DownloadDocumentoModel extends Model{

    private $table = "`coc`.`downloads_documentos`";
    private $model = "DownloadDocumentoModel";
    private $usuario = "USER";

    function add($data){

        $this->populate($data);

        $sql = "INSERT INTO ".$this->table." 
                (`id_documento`,
                `id_usuario`,
                `data_download`)
                VALUES
                (:id_documento,
                :id_usuario,
                curtime())";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id_documento', $this->id_documento, PDO::PARAM_STR);
        $query->bindValue(':id_usuario', $_SESSION['id'], PDO::PARAM_STR);
        
        $result = Database::executa($query);   

        $this->log->setInfo("Fez Download ($this->model) do documento $this->id_documento");

        return $result;
    }

    function getInfo($data){

        $this->populate($data);

        $sql = "SELECT usu.email,dow_doc.data_download FROM coc.downloads_documentos dow_doc
                    INNER JOIN coc.documentos doc
                        on dow_doc.id_documento = doc.id
                    INNER JOIN coc.usuarios usu
                        on dow_doc.id_usuario =  usu.id
                    WHERE id_documento = :id_documento";

        $query = $this->conn->prepare($sql);

        $query->bindValue(':id_documento', $this->id_documento, PDO::PARAM_STR);
        
        $result = Database::executa($query);   

        $this->log->setInfo("Buscou informações de download ($this->model) do documento $this->id_documento");

        return $result;
    }


}

