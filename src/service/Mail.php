<?php

namespace service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    private string $username;
    private string $password;
    private string $sender;
    private string $receiver;
    private string $receiverAddress;
    private int $userId;
    private string $token;
    private string $subject = 'Hello from PHPMailer';
    private string $body = 'This is a <b>test email</b> sent using PHPMailer';



    // constructor
    public function __construct(string $receiver, string $address, int $userId, string $token)
    {
        $this->username = $_ENV['MAIL_USERNAME'];
        $this->password = $_ENV['MAIL_PASSWORD'];
        $this->sender = $_ENV['MAIL_SENDER'];
        $this->receiver = $receiver;
        $this->receiverAddress = $address;
        $this->userId = $userId;
        $this->token = $token;
        $this->setContent();
    }

    public function sendMail(): void
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';      // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;    // Your Gmail address
            $mail->Password = $this->password;       // App password (not Gmail password)
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($this->sender, $this->sender);
            $mail->addAddress($this->receiverAddress, $this->receiver);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;

            $mail->send();
            echo 'Email has been sent!';
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }

    public function setContent(): void
    {
        $body = '
    <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        <div style="background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; text-align: center;">
            <h1>Hello, ' . htmlspecialchars($this->receiver) . '!</h1>
            <h2 style="color: #333;">Please verify your email address</h2>
            <p style="color: #555;">Click the button below to verify your email address:</p>

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/user/verify?key=' . urlencode($this->token) . '&id=' . urlencode($this->userId) . '&email=' . urlencode($this->receiverAddress) . '"
               style="display: inline-block; background-color: #007BFF; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Verify Email
            </a>

            <p style="margin-top: 30px; color: #999;">Thanks,<br>Team Glow Edge Studios</p>
        </div>
    </div>
';
        $this->body = $body;

    }

}