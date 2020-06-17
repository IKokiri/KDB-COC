<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{

    private $mail;

    function __construct(){
        $this->mail = new PHPMailer(true);
    }

    function config(){
        //Server settings
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $this->mail->isSMTP();                                            // Send using SMTP
        $this->mail->Host       = 'mail.kuttner.com.br';                    // Set the SMTP server to send through
        // $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mail->Username   = 'ordemcompra@kuttner.com.br';                     // SMTP username
        $this->mail->Password   = '';                               // SMTP password
        // $this->mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPAutoTLS = false;
        $this->mail->Port       = 587;     
        //Recipients
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
        // DESCOMENTAR DESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTARDESCOMENTAR
            $this->mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    
}
