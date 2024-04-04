<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarEmail()
    {
        // Crear el objeto de PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalonTaz.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set html
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has creado tu cuenta en App Salon Taz, Confirma la confirmación en el siguiente enlace.</p>';
        $contenido .= '<p>Presiona aquí: <a href="' . $_ENV['APP_URL'] . '/confirmar-cuenta?token=' . $this->token . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p>Si no has creado la cuenta, ignora este mensaje.</p>';
        $contenido .= '</html>';
        $mail->msgHTML($contenido);

        $mail->send();
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalonTaz.com');
        $mail->Subject = 'Reestablece tu contraseña';

        // Set html
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>';
        $contenido .= '<p>Presiona aquí: <a href="' . $_ENV['APP_URL'] . '/recuperar?token=' . $this->token . '">Reestablecer Contraseña</a></p>';
        $contenido .= '<p>Si tu no solicitaste este cambio, ignora este mensaje.</p>';
        $contenido .= '</html>';
        $mail->msgHTML($contenido);

        $mail->send();
    }

}
