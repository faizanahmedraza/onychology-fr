<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require_once './vendor/autoload.php';

class MailSender {
    private $host;
    private $port;
    private $username;
    private $password;
    private $address;
    private $encryption;
    private $from;
    private $debug = 0;

    public function __construct(array $config)
    {
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->address = $config['address'];
        $this->from = $config['from'];
        $this->encryption = $config['encryption'];
        $this->debug = $config['debug'];
    }

    public function sendMail($toAddress,$toName,$subject,$htmlTemplatePath)
    {
        try {
            $mail = new PHPMailer(TRUE);
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPDebug = $this->debug;
            $mail->setLanguage('fr');
            $mail->CharSet = 'UTF-8';
//            $mail->SMTPAuth = TRUE;
//            $mail->SMTPSecure = $this->encryption;
//            $mail->Host = $this->host;
//            $mail->Port = $this->port;
//            $mail->Username = $this->username;
//            $mail->Password = $this->password;
            $mail->Host = 'localhost';
            $mail->SMTPAuth = false;
            $mail->SMTPAutoTLS = false;
            $mail->Port = 25;
            $mail->IsHTML(true);
            $mail->SetFrom($this->address, $this->from);
            $mail->AddAddress($toAddress, $toName);
            $mail->Subject = $subject;
            $content = $htmlTemplatePath;
            $mail->MsgHTML($content);
            if(!$mail->Send()) {
                echo "Error while sending Email.";
            } else {
                echo "Email sent successfully";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}