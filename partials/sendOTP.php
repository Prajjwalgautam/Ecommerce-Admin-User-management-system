<?php
$email = $_POST["email"];
$otp = rand(100000, 999999); // Generate a 6-digit OTP

include('database.php');

$sql = "SELECT * FROM ecommerce WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $email]);
$count = $stmt->rowCount();

if ($count > 0) {
    $sql_update_statement = "UPDATE ecommerce SET otp = :otp WHERE email = :email";
    $statement = $pdo->prepare($sql_update_statement);
    $statement->execute(["otp" => $otp, "email" => $email]);

    try {
        require 'emailAPI.php';

        $mail->setFrom($sender, 'OTP Sender');
        $mail->addAddress($email, 'Syntax Flow');
        $mail->addReplyTo($sender, 'OTP Sender');

        $mail->isHTML(true);
        $mail->Subject = 'One Time Password - OTP';
        $mail->Body = 'Hi, here is your one-time password:<br/><br><strong>' . $otp . '</strong><br/>';

        $mail->send();
        echo 'Hi, your OTP has been sent to your email<br/>';
        echo '<a href="enterOTP.php">Enter your OTP to reset your password</a>';
    } catch (Exception $e) {
        echo "An error occurred. The message cannot be sent: {$mail->ErrorInfo}";
    }
} else {
    echo "The email is not registered";
}
