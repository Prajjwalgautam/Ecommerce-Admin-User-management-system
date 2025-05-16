<?php
session_start();
include('partials/database.php');
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// JWT Configuration
define('JWT_SECRET', 'xK2!9pL$4qW#7zR*1vY8uN6tG5bH3mJ0c');
define('JWT_ALGORITHM', 'HS256');
define('JWT_EXPIRATION', 3600);

// Redirect if already logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['jwt_token'])) {

    include("partials/database.php");
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM ecommerce WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // If the user does not exist, destroy the session and redirect to login page
    if (mysqli_num_rows($result) === 0) {
        // Clear session and cookies
        session_unset();
        session_destroy();
        setcookie('jwt', '', time() - 3600, '/'); // Delete the JWT cookie
        header("Location: login.php");
        exit();
    } else {
        // User exists, proceed with role-based redirection
        $user = mysqli_fetch_assoc($result);
        $role = strtolower($user['role']) === 'admin' ? 'admin' : 'user';
        header("Location: " . ($role === 'admin' ? 'index.php' : 'user.php'));
        exit();
    }
}

$email = $password = $error = $email_error = $password_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    // Validation
    if (empty($email)) {
        $email_error = "Please enter email!";
    }

    if (empty($password)) {
        $password_error = "Please enter password!";
    }

    if (empty($email_error) && empty($password_error)) {
        $email_escaped = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM ecommerce WHERE email = '$email_escaped'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Create JWT payload
            $payload = [
                'iat' => time(), // Issued at
                'exp' => time() + JWT_EXPIRATION, // Expiration time
                'data' => [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ]
            ];

            // Generate JWT
            $jwt = JWT::encode($payload, JWT_SECRET, JWT_ALGORITHM);

            // Store in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            $_SESSION['jwt_token'] = $jwt;

            // Set JWT as HTTP-only cookie for better security
            setcookie('jwt', $jwt, [
                'expires' => time() + JWT_EXPIRATION,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            // Redirect based on role (default to 'user' if role is invalid or missing)
            $role = isset($user['role']) && strtolower($user['role']) === 'admin' ? 'admin' : 'user';
            header("Location: " . ($role === 'admin' ? 'index.php' : 'user.php'));
            exit();
        } else {
            $error = "Incorrect email or password!";
        }
    }
}

?>



</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts and styles -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        <?php if ($error) echo "<p class='text-danger'>$error</p>"; ?>
                                    </div>

                                    <form class="user" method="POST" action="">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="emailInput" placeholder="Enter Email Address...">
                                            <?php if ($email_error) echo "<p class='text-danger'>$email_error</p>"; ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="passwordInput" placeholder="Password">
                                            <?php if ($password_error) echo "<p class='text-danger'>$password_error</p>"; ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>

                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="reset_password.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $(document).ready(function() {
            $('#emailInput').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('#emailError').text('');
                }
            });

            $('#passwordInput').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('#passwordError').text('');
                }
            });

            // Optional: Clear general error on any input
            $('.form-control-user').on('input', function() {
                $('.text-danger').text('');
            });
        });
    </script>
</body>

</html>