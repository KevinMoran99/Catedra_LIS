<?php

namespace Http\Helpers;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require "../../../vendor/autoload.php";

class Mailer {
    public static $RESETPASS = 1;
    public static $CONFIRMHASH = 2;

    /**
     * Envía un correo
     * params: 
     * $email - El email de destino
     * $code - El hash a enviar
     * $messageType - El tipo de mensaje, 1 si es de recuperacion de contraseña, 2 si es de confirmacion de cuenta
     */
    public static function sendMail($email, $code, $messageType){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mailtrap.io';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'b0558e807c64c2';                   // SMTP username
            $mail->Password = '748ca1e246dcf8';                   // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                     // TCP port to connect to
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('expoxvi@gmail.com', 'Mailer');
            $mail->addAddress($email);                            // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $messageType == 1 ? 'Mensaje de recuperación de contraseña' : 'Mensaje de confirmación de inicio de sesión';
            $mail->Body    = '<style>
                                body {
                                    background: linear-gradient(mediumspringgreen, skyblue);
                                    font-family: sans-serif;
                                }
                                h3 {
                                    color: white;
                                    background-color: steelblue;
                                    padding: 2px;
                                    border-radius: 5px;
                                }
                                div {
                                    background-color: white;
                                    padding: 5px;
                                    border-radius: 3px;
                                }
                                b {
                                    color: steelblue;
                                    text-align: center;
                                }
                              </style>
                              <h3>Sttom xD</h3>
                              <div>'.
                              ($messageType == 1 ?
                                '<p>Usted ha solicitado una recuperación de contraseña para su cuenta de stoam.</p>
                                <p>Su nueva contraseña es:</p> 
                                <b>' . $code . '</b>
                                <p>Le recomendamos volver a cambiar su contraseña por una que usted prefiera al volver a ingresar el sistema.</p>'
                              :
                                '<p>Ha solicitado un inicio de sesión en su cuenta de stoam.</p>
                                <p>Su código de confirmación es:</p> 
                                <b>' . $code . '</b>
                                <p>¡Disfrute el viaje!</p>')
                              .'</div>';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
}

