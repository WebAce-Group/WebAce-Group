<?php

require_once dirname(__FILE__) . "/phpMailer/ManualLoader.php";

use PHPMailer\PHPMailer\PHPMailer;

class Mailer_API
{
    private $mail = null;

    /**
     * PHP Mailer is a class that allows you to send emails using PHP. 
     * 
     * The below function is a constructor function. It is called when you create a new instance of
     * the class. 
     */
    function __construct()
    {
        //for debugging
        // $this->mail = new PHPMailer(true);
        // $this->mail->SMTPDebug = 4;
        // $this->mail->Debugoutput = 'html';

        //for production
        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = 0;

        $this->mail->CharSet = "UTF-8";
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPAutoTLS = true;

        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPKeepAlive = true;
        $this->mail->Host = SERWER_SMTP;
        $this->mail->Port = PORT_SMTP;
        $this->mail->WordWrap = 78;
        $this->mail->Priority = 1;
        $this->mail->isSMTP();
    }

    /**
     * It sends an email from a contact form.
     * 
     * @param email the email address of the person who sent the message
     * @param name the name of the person who sent the message
     * @param surname the surname of the person who sent the messeage
     * @param subject the subject of the message
     * @param message the message that was sent
     * 
     * @return The response is an array with the following keys:
     * code - the code of the response
     * msg - the message of the response
     * title - the title of the response
     * icon - the icon of the response
     * btn_text - the text of the button of the response
     */
    public function sendContactMail($email, $name, $subject, $message)
    {
        $this->mail->Username = LOGIN_KONTAKT;
        $this->mail->Password = PASSWORD_KONTAKT;
        $this->mail->setFrom(SET_FROM, $name);
        $this->mail->From = LOGIN_KONTAKT;
        $this->mail->FromName = $name . " - " . $email;
        $this->mail->addAddress(LOGIN_KONTAKT);
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body =
        '<!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nowa wiadomość</title>
        </head>
        <body>
            <p>Nowa wiadomość od: ' . $name . ' - ' . $email . '</p>
            <p>Treść wiadomości:</p>
            '.$message.'
        </body>
        </html>';
        $this->mail->AltBody = $message;
        if (!$this->mail->send()) {
            $response["code"] = 13;
            $response["msg"] = $this->mail->ErrorInfo;
            $response["title"] = "Nie udało się wysłać maila.\nKod błędu: 13";
            $response["icon"] = "error";
            $response["btn_text"] = "OK";
        } else {
            $response["code"] = 0;
            $response["msg"] = "Wiadomość została wysłana";
            $response["title"] = "Zrobione!";
            $response["icon"] = "success";
            $response["btn_text"] = "OK";
        }
        return $response;
    }
}
