<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'settings.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                     // Use SMTP
    $mail->Host       = $host;                           // SMTP server
    $mail->SMTPAuth   = true;                            // Enable SMTP authentication
    $mail->Username   = $username;                       // SMTP username
    $mail->Password   = $hostpassword;                   // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     // Enable implicit TLS encryption
    $mail->Port       = 465;                             // TCP port for SMTPS

    // You will add recipient, subject, and body in the file where this is included
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
