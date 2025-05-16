<?php
include('database.php');

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update = "UPDATE ecommerce SET password = :password, otp = NULL WHERE email = :email";
        $stmt = $pdo->prepare($update);
        $stmt->execute(['password' => $hashed_password, 'email' => $email]);
        echo "Password reset successful! <a href='login.php'>Login Now</a>";
    } else {
        echo "Passwords do not match.";
    }
    exit;
}

// Handle OTP form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $otp = $_POST['otp'];
    $sql = "SELECT * FROM ecommerce WHERE otp = :otp";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['otp' => $otp]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $email = $user['email'];
?>

        <h2>Reset Your Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <button type="submit">Reset Password</button>
        </form>

<?php
    } else {
        echo "Invalid OTP. Please try again.";
    }
} else {
    echo "Invalid request!";
}
?>