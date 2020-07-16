<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Mail\InfoMail;

class Mail extends InfoMail{

    private $mail;

    function __construct(){
        $this->mail = new PHPMailer(true);
    }

    function config(){
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;   
        $this->mail->isSMTP();                                            
        $this->mail->Host       = $this->host;                  
        $this->mail->Username   = $this->username;           
        $this->mail->Password   = $this->password; 
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPAutoTLS = false;
        $this->mail->Port       = 587;     
        $this->mail->setFrom('ordemcompra@kuttner.com.br', 'Ordem de Compra KdB');
    }

    function destinatario($destinatario){
        $this->mail->addAddress($destinatario); 
    }

    function send($assunto,$corpo){

        try {
            $this->config();

            $this->mail->isHTML(true);                                
            $this->mail->Subject = $assunto;
            $this->mail->Body    = $corpo;
            $this->mail->AltBody = $corpo;
            $this->mail->send();
        } catch (Exception $e) {
            return "Não enviado";
        }
    }

    
}
