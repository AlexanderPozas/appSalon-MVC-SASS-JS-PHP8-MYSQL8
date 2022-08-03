<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c7996675630a8d';
        $mail->Password = 'e049f264f053f3';
        $mail->CharSet = 'UTF-8';

        /**Servidor de email y destinatario */
        $mail->setFrom('cuenta@appsalon.com');
        $mail->addAddress('cuenta@appsalon.com');

        /**Agregar una imagen al correo como archivo adjunto*/
        $imgLocation = __DIR__ . '/../public/build/img/1.jpg';
        $mail->addAttachment($imgLocation);

        /**Contenido del email */
        $mail->isHTML(true);
        $mail->Subject = 'Confirmar Email - AppSalon';

        $contenido = "<html>";
        $contenido .= "<p style = \"background:tomato; padding:20px 10px;\"><strong>Hola " . $this->email . "</strong> has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aquí: </p><a href='http://localhost:3000/confirmar-cuenta?token=" .$this->token. "'>Confirmar Cuenta</a>";
        $contenido .= "<img display:block; height=\"100px\" width=\"100px\" src='". $imgLocation ."'>";
        $contenido .= "<p>Si tu no solicitaste está cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        /**Enviar el email */
        $mail->send();

    }
    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c7996675630a8d';
        $mail->Password = 'e049f264f053f3';
        $mail->CharSet = 'UTF-8';

        /**Servidor de email y destinatario */
        $mail->setFrom('cuenta@appsalon.com');
        $mail->addAddress('cuenta@appsalon.com');

        /**Agregar una imagen al correo como archivo adjunto*/
        $imgLocation = __DIR__ . '/../public/build/img/1.jpg';
        $mail->addAttachment($imgLocation);

        /**Contenido del email */
        $mail->isHTML(true);
        $mail->Subject = 'Reestablece tu Password - AppSalon';

        $contenido = "<html>";
        $contenido .= "<p style = \"background:tomato; padding:20px 10px;\"><strong>Hola " . $this->nombre . "</strong> has solicitado reestablecer tu Password, sigue el enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona Aquí: </p><a href='http://localhost:3000/recover?token=" .$this->token. "'>Reestablecer Password</a>";
        $contenido .= "<img display:block; height=\"100px\" width=\"100px\" src='". $imgLocation ."'>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        /**Enviar el email */
        $mail->send();
    }
}
