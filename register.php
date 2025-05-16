<?php
include("partials/database.php");

$firstname = null;
$lastname = null;
$email = null;
$passwordconfirm = null;
$password = null;
$address = null;
$address_error = null;
$role = null;

$firstname_error = null;
$lastname_error = null;
$email_error = null;
$password_error = null;
$passwordconfirm_error = null;
$role_error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS));
    $lastname = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS));
    $raw_email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $email = $raw_email ? mysqli_real_escape_string($conn, $raw_email) : "";

    $password = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));
    $address = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS));
    $passwordconfirm = mysqli_real_escape_string($conn, string: filter_input(INPUT_POST, "passwordconfirm", FILTER_SANITIZE_SPECIAL_CHARS));
    $role = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "role"));
    $error = false;

    if (empty(trim($firstname))) {
        $firstname_error = "Please enter a first name!";
        $error = true;
    }
    if (empty(trim($lastname))) {
        $lastname_error = "Please enter a last name!";
        $error = true;
    }


    if (empty($email)) {
        $email_error = "Please enter a valid email!";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format!";
        $error = true;
    } elseif (preg_match('/(\.\w{2,}){2,}/', $email)) {
        $email_error = "Email cannot contain multiple domain";
        $error = true;
    } elseif (preg_match('/[\r\n]/', $email)) {
        $email_error = "Email contains invalid characters.";
        $error = true;
    } else {
        $stmt = $conn->prepare("SELECT id FROM ecommerce WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $email_error = "This email is already taken.";
            $error = true;
        }

        $stmt->close();
    }

    if (empty(trim($password))) {
        $password_error = "Please enter a password!";
        $error = true;
    } elseif (!preg_match('/^(?=.*[A-Z])(?=(?:.*\d){2,}).{6,}$/', $password)) {
        $password_error = "Password must be 6 characters long, 1 uppercase letter and 2 digits.";
        $error = true;
    }
    if (empty(trim($address))) {
        $address_error = "Please enter a address!";
        $error = true;
    }



    if (!$error) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO ecommerce (firstname, lastname, email, password,address) VALUES ('$firstname', '$lastname', '$email', '$hash' ,'$address')";
        $success = "Thank you for signing up.";

        try {
            mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception $e) {
            echo "That email is already taken.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Register</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function togglePasswordVisibility(icon) {
            const inputId = icon.getAttribute("data-target");
            const input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const firstNameInput = document.getElementById("firstname");
            const lastNameInput = document.getElementById("lastname");
            const emailInput = document.getElementById("email");

            const capitalizeFirstLetter = (input) => {
                const val = input.value.trim();
                if (val.length > 0) {
                    input.value = val.charAt(0).toUpperCase() + val.slice(1).toLowerCase();
                }
            };

            firstNameInput.addEventListener("blur", () => capitalizeFirstLetter(firstNameInput));
            lastNameInput.addEventListener("blur", () => capitalizeFirstLetter(lastNameInput));

            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("passwordconfirm");
            const matchMessage = document.getElementById("matchMessage");

            const toggleIcons = [{
                    input: password,
                    icon: document.querySelector('i[data-target="password"]')
                },
                {
                    input: confirmPassword,
                    icon: document.querySelector('i[data-target="passwordconfirm"]')
                }
            ];

            toggleIcons.forEach(({
                input,
                icon
            }) => {
                const updateIconVisibility = () => {
                    if (input.value.trim() !== "") {
                        icon.style.visibility = "visible";
                    } else {
                        icon.style.visibility = "hidden";
                        input.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                };

                input.addEventListener("input", updateIconVisibility);
                input.addEventListener("blur", updateIconVisibility);
                updateIconVisibility();
            });

            confirmPassword.addEventListener("input", function() {
                if (confirmPassword.value === "") {
                    matchMessage.textContent = "";
                    return;
                }

                if (confirmPassword.value !== password.value) {
                    matchMessage.textContent = "Passwords do not match!";
                    matchMessage.style.color = "red";
                } else {
                    matchMessage.textContent = "Passwords match.";
                    matchMessage.style.color = "green";
                }
            });

            // Email validation
            emailInput.addEventListener("blur", function() {
                const email = emailInput.value.trim();
                const validRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                let errorMsgEl = emailInput.nextElementSibling;

                if (errorMsgEl && !errorMsgEl.classList.contains("text-danger")) {
                    errorMsgEl = null;
                }

                if (email === "") {
                    if (errorMsgEl) errorMsgEl.textContent = "";
                } else if (!validRegex.test(email)) {
                    if (!errorMsgEl) {
                        const errorP = document.createElement("p");
                        errorP.className = "text-danger";
                        errorP.textContent = "Please enter a valid email address!";
                        emailInput.insertAdjacentElement("afterend", errorP);
                    } else {
                        errorMsgEl.textContent = "Please enter a valid email address!";
                    }
                } else {
                    if (errorMsgEl) errorMsgEl.textContent = "";
                }
            });
        });
    </script>


</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                <?php if ($success) echo "<p class='text-success'>$success</p>"; ?>
                            </div>
                            <form class="user" method="POST" action="" autocomplete="off">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" id="firstname" name="firstname" class="form-control form-control-user" placeholder="First Name">
                                        <?php if ($firstname_error) echo "<p class='text-danger'>$firstname_error</p>"; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="lastname" name="lastname" class="form-control form-control-user" placeholder="Last Name">
                                        <?php if ($lastname_error) echo "<p class='text-danger'>$lastname_error</p>"; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="email" name="email" class="form-control form-control-user" placeholder="Email Address">
                                    <?php if ($email_error) echo "<p class='text-danger'>$email_error</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="address" name="address" class="form-control form-control-user" placeholder="Address">
                                    <?php if ($address_error) echo "<p class='text-danger'>$address_error</p>"; ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div style="position: relative;">
                                            <input type="password" id="password" name="password" class="form-control form-control-user" placeholder="Password">
                                            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility(this)" data-target="password"
                                                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                                        </div>
                                        <?php if ($password_error) echo "<p class='text-danger'>$password_error</p>"; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="position: relative;">
                                            <input type="password" id="passwordconfirm" name="passwordconfirm" class="form-control form-control-user" placeholder="Password Confirm">
                                            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility(this)" data-target="passwordconfirm"
                                                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                                        </div>
                                        <p id="matchMessage" class="small mt-1"></p>
                                        <?php if ($passwordconfirm_error) echo "<p class='text-danger'>$passwordconfirm_error</p>"; ?>
                                    </div>
                                </div>
                                <div class="dropdown">


                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="index.php" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>