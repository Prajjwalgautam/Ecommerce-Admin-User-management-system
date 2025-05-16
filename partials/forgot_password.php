<?php
$email = $_POST["email"];
$otp = rand(100000, 999999); // 6-digit OTP

include('database.php');

$sql = "SELECT * FROM ecommerce WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $email]);

if ($stmt->rowCount() > 0) {
    $updateOtp = "UPDATE ecommerce SET otp = :otp WHERE email = :email";
    $stmt = $pdo->prepare($updateOtp);
    $stmt->execute(["otp" => $otp, "email" => $email]);

    // Send Email
    require 'emailAPI.php';
    $mail->setFrom($sender, 'OTP System');
    $mail->addAddress($email);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = "Your OTP is: $otp";
    $mail->send();

    echo "OTP sent successfully to your email.";
    echo '<br><a href="enterOTP.php">Click here to enter OTP</a>';
} else {
    echo "Email not registered.";
}
