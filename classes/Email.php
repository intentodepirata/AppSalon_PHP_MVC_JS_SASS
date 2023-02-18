<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;


    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion(){
        $phpmailer = new PHPMailer();

        //configurar smtp
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'intentodepirata@gmail.com';
        $phpmailer->Password = 'msjmegcyyrzdrjqi';
        $phpmailer->SMTPSecure = 'tls';

        //configurar el contenido
        $phpmailer->setFrom('intentodepirata@gmail.com', 'Antonio');
        $phpmailer->addAddress($this->email, $this->nombre); 
        $phpmailer->Subject = 'Confirma tu Cuenta';

        //Habilitar HTML
        $phpmailer->isHTML(true);       
        $phpmailer->CharSet = 'UTF-8';     
        
        //Definir el contenido     
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en LucatoniBarberShop, por favor 
        confirma tu cuenta presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='https://fathomless-savannah-26199.herokuapp.com/confirmar-cuenta?token=" .$this->token . "'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si no solicitastes este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $phpmailer->Body = $contenido;

        $phpmailer->send();
    }

    public function enviarInstrucciones(){
        $phpmailer = new PHPMailer();

        //configurar smtp
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'intentodepirata@gmail.com';
        $phpmailer->Password = 'msjmegcyyrzdrjqi';
        $phpmailer->SMTPSecure = 'tls';

        //configurar el contenido
        $phpmailer->setFrom('intentodepirata@gmail.com', 'Antonio');
        $phpmailer->addAddress($this->email, $this->nombre); 
        $phpmailer->Subject = 'Reestablece tu Password';

        //Habilitar HTML
        $phpmailer->isHTML(true);       
        $phpmailer->CharSet = 'UTF-8';     
        
        //Definir el contenido     
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password, reestablece tu password presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='https://fathomless-savannah-26199.herokuapp.com/recuperar?token=" .$this->token . "'>Reestablecer tu contraseña</a> </p>";
        $contenido .= "<p>Si no solicitastes este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $phpmailer->Body = $contenido;

        $phpmailer->send();
    }
};