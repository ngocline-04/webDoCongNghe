<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('vendor/autoload.php'); // nếu cài PHPMailer bằng composer


class Email 
{
    protected $message;
    protected $subject;

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }
    
    public function send($toEmail)
    {
        global $mailHost, $SMTPAuth, $userMail, $userPassword, $mailPort;

        $mail = new PHPMailer(true);

        try {
            // SMTP
            $mail->isSMTP();
            $mail->Host       = $mailHost;
            $mail->SMTPAuth   = $SMTPAuth;
            $mail->Username   = $userMail;
            $mail->Password   = $userPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // port 465
            $mail->Port       = $mailPort;
            $mail->CharSet    = 'UTF-8';

            // Sender
            $mail->setFrom($userMail, 'Web Đồ Công Nghệ');

            // Receiver
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->message;

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
