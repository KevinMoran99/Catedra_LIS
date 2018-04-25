<?php

namespace Http\Helpers;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require "../../../vendor/autoload.php";

class Mailer {
    public static function resetPassword($email, $pass){
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
            $mail->Subject = 'Mensaje de recuperación de contraseña';
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
                              <div>
                                <p>Usted ha solicitado una recuperación de contraseña para su cuenta de stoam.</p>
                                <p>Su nueva contraseña es:</p> 
                                <b>' . $pass . '</b>
                                <p>Le recomendamos volver a cambiar su contraseña por una que usted prefiera al volver a ingresar el sistema.</p>
                              </div>';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
}

