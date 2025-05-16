<?php
session_start();
include('partials/database.php');
include("partials/profiledata.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}




?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        // Simple modal control
        window.onclick = function(event) {
            const modal = document.getElementById('addCatalogModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="user.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="user_tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>User-table</span></a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Nav Item - Tables -->


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <!-- Nav Item - Alerts -->

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo htmlspecialchars($user['firstname'] ?? ''); ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo !empty($profile['profile_image']) ? htmlspecialchars($profile['profile_image']) : 'img/undraw_profile.svg'; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="adminprofile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!--  Catalog Button -->
                <div class="container mt-3">
                    <?php if (isset($_SESSION['alert'])): ?>
                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['alert']['message'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php unset($_SESSION['alert']); ?>
                    <?php endif; ?>
                </div>

                <div class="text-right my-3 mr-3">
                    <button id="showFormBtn" class="btn btn-primary">Add User</button>

                    <?php

                    $firstname = $_POST['firstname'] ?? '';
                    $lastname = $_POST['lastname'] ?? '';
                    $email = $_POST['email'] ?? '';
                    $address = $_POST['address'] ?? '';
                    $first_error = null;
                    $last_error = null;
                    $pass_error = null;
                    $email_error = null;

                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $firstname = mysqli_real_escape_string($conn, $firstname);
                        $lastname = mysqli_real_escape_string($conn, $lastname);
                        $email = mysqli_real_escape_string($conn, $email);
                        $raw_password = $_POST['password'] ?? '';
                        $address = mysqli_real_escape_string($conn, $address);

                        $hasError = false;

                        if (empty($firstname)) {
                            $first_error = "First name is required!";
                            $hasError = true;
                        }

                        if (empty($lastname)) {
                            $last_error = "Last name is required!";
                            $hasError = true;
                        }

                        if (empty($email)) {
                            $email_error = "Please enter a valid email!";
                            $hasError = true;
                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $email_error = "Invalid email format!";
                            $hasError = true;
                        } elseif (preg_match('/(\.\w{2,}){2,}/', $email)) {
                            $email_error = "Email cannot contain multiple domain";
                            $hasError = true;
                        } elseif (preg_match('/[\r\n]/', $email)) {
                            $email_error = "Email contains invalid characters.";
                            $hasError = true;
                        } else {
                            $stmt = $conn->prepare("SELECT id FROM ecommerce WHERE email = ?");
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $email_error = "This email is already taken.";
                                $hasError = true;
                            }

                            $stmt->close();
                        }

                        if (empty($raw_password)) {
                            $pass_error = "Password is required!";
                            $hasError = true;
                        } elseif (!preg_match('/^(?=.*[A-Z])(?=(?:.*\d){2,}).{6,}$/', $raw_password)) {
                            $pass_error = "Password must be at least 6 characters, include 1 uppercase letter and 2 digits.";
                            $hasError = true;
                        }

                        if (!$hasError) {
                            $password = password_hash($raw_password, PASSWORD_DEFAULT);

                            $sql = "INSERT INTO ecommerce (firstname, lastname, email, password, address) 
                    VALUES (?, ?, ?, ?, ?)";

                            $stmt = mysqli_prepare($conn, $sql);

                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $password, $address);

                                try {
                                    ob_start();
                                    if (mysqli_stmt_execute($stmt)) {
                                        $_SESSION['alert'] = [
                                            'type' => 'success',
                                            'message' => 'User added successfully!'
                                        ];
                                        // Clear form values on success
                                        $firstname = $lastname = $email = $address = '';
                                    } else {
                                        $_SESSION['alert'] = [
                                            'type' => 'danger',
                                            'message' => 'Error executing query: ' . mysqli_error($conn)
                                        ];
                                    }
                                } catch (mysqli_sql_exception $e) {
                                    $_SESSION['alert'] = [
                                        'type' => 'danger',
                                        'message' => 'Database error: ' . $e->getMessage()
                                    ];
                                }

                                mysqli_stmt_close($stmt);
                            } else {
                                $_SESSION['alert'] = [
                                    'type' => 'danger',
                                    'message' => 'Error preparing statement: ' . mysqli_error($conn)
                                ];
                            }
                        }
                    }
                    ?>

                    <!-- Floating Form Box -->
                    <div id="catalogFormBox" class="form-box" <?php echo ($_SERVER['REQUEST_METHOD'] == "POST" && $hasError) ? 'style="display: block;"' : ''; ?>>
                        <form method="POST" id="catalogForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <h3>Add Users</h3>
                            <input class="catalogform" type="text" name="firstname" placeholder="Firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
                            <?php if ($first_error) echo "<p class='text-danger'>$first_error</p>"; ?>
                            <input class="catalogform" type="text" name="lastname" placeholder="Lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
                            <?php if ($last_error) echo "<p class='text-danger'>$last_error</p>"; ?>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password" placeholder="Password" required style="padding-right: 40px;">
                                <?php if ($pass_error) echo "<p class='text-danger'>$pass_error</p>"; ?>
                                <span id="togglePassword" style="
                    position: absolute;
                    right: 10px;
                    top: 32%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    font-size: 18px;">
                                    👁️
                                </span>
                            </div>

                            <script>
                                const togglePassword = document.getElementById("togglePassword");
                                const passwordInput = document.getElementById("password");

                                togglePassword.addEventListener("click", function() {
                                    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                                    passwordInput.setAttribute("type", type);
                                    this.textContent = type === "password" ? "👁️" : "🙈";
                                });

                                passwordInput.addEventListener('input', function() {
                                    const password = this.value;
                                    const strengthText = document.getElementById('passwordStrength') || createStrengthIndicator();

                                    if (password.length === 0) {
                                        strengthText.textContent = '';
                                        return;
                                    }

                                    // Check minimum length
                                    if (password.length < 6) {
                                        strengthText.textContent = 'Password must be at least 6 characters';
                                        strengthText.style.color = 'red';
                                        return;
                                    }

                                    // Check for at least one capital letter
                                    const hasCapital = /[A-Z]/.test(password);
                                    // Check for at least two digits
                                    const digitCount = (password.match(/\d/g) || []).length;
                                    const hasTwoDigits = digitCount >= 2;

                                    if (!hasCapital || !hasTwoDigits) {
                                        let message = 'Password needs: ';
                                        const requirements = [];
                                        if (!hasCapital) requirements.push('one capital letter');
                                        if (!hasTwoDigits) requirements.push('two digits');
                                        strengthText.textContent = message + requirements.join(' and ');
                                        strengthText.style.color = 'red';
                                        return;
                                    }

                                    // Calculate strength
                                    let strength = 0;
                                    if (password.length >= 8) strength++;
                                    if (password.length >= 12) strength++;
                                    if (digitCount >= 3) strength++;
                                    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

                                    if (strength <= 2) {
                                        strengthText.textContent = 'Strength: Weak';
                                        strengthText.style.color = 'orange';
                                    } else if (strength <= 4) {
                                        strengthText.textContent = 'Strength: Medium';
                                        strengthText.style.color = 'blue';
                                    } else {
                                        strengthText.textContent = 'Strength: Super Strong!';
                                        strengthText.style.color = 'green';
                                    }
                                });

                                function createStrengthIndicator() {
                                    const indicator = document.createElement('div');
                                    indicator.id = 'passwordStrength';
                                    indicator.style.marginTop = '5px';
                                    indicator.style.fontSize = '14px';
                                    passwordInput.parentNode.insertBefore(indicator, passwordInput.nextSibling);
                                    return indicator;
                                }
                            </script>

                            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                            <?php if ($email_error) echo "<p class='text-danger'>$email_error</p>"; ?>

                            <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($address); ?>" required>

                            <div class="form-buttons">
                                <button type="submit" style="background: #007bff; color: white;" name="add_user" id="saveButton">Save</button>
                                <a href="user_tables.php"> <button type="button" style="background:rgba(0, 123, 157, 0.61); color: white;" id="cancelFormBtn">Cancel</button></a>
                            </div>
                        </form>
                    </div>

                    <style>
                        .form-box {
                            display: none;
                            position: fixed;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            background: white;
                            border-radius: 12px;
                            padding: 30px;
                            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                            z-index: 9999;
                            min-width: 300px;
                            animation: fadeIn 0.3s ease-in-out;
                        }

                        .form-box h3 {
                            margin-bottom: 20px;
                        }

                        .form-box input {
                            width: 100%;
                            margin-bottom: 15px;
                            padding: 10px;
                            font-size: 14px;
                            border: 1px solid #ccc;
                            border-radius: 6px;
                        }

                        .form-buttons {
                            display: flex;
                            justify-content: flex-end;
                            gap: 10px;
                        }

                        .form-buttons button {
                            padding: 8px 16px;
                            border: none;
                            cursor: pointer;
                            border-radius: 6px;
                        }

                        .form-buttons button[type="submit"] {
                            background-color: #007bff;
                            color: white;
                        }

                        .form-buttons button[type="button"] {
                            background-color: #ccc;
                            color: black;
                        }

                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                                transform: translate(-50%, -60%);
                            }

                            to {
                                opacity: 1;
                                transform: translate(-50%, -50%);
                            }
                        }
                    </style>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const showBtn = document.getElementById('showFormBtn');
                            const formBox = document.getElementById('catalogFormBox');
                            const cancelBtn = document.getElementById('cancelFormBtn');

                            showBtn.addEventListener('click', () => {
                                formBox.style.display = 'block';
                                formBox.querySelector('input[name="firstname"]').focus();
                            });

                            cancelBtn.addEventListener('click', () => {
                                formBox.style.display = 'none';
                                document.getElementById('catalogForm').reset();
                            });
                        });
                    </script>
                </div>

                <!-- /.container-fluid -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>LastName</th>
                                        <th>email</th>
                                        <th>address</th>

                                        <th>action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    include_once("partials/database.php");



                                    $sql = "SELECT * FROM ecommerce ";
                                    $result = mysqli_query($conn, $sql);


                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['firstname'] . '</td>';
                                            echo '<td>' . $row['lastname'] . '</td>';
                                            echo '<td>' . $row['email'] . '</td>';
                                            echo '<td>' . $row['address'] . '</td>';

                                            echo '<td>
    <a href="user-edit.php?id=' . $row['id'] . '" class="btn btn-success btn-sm me-2">Edit</a>
    <a href="user-view.php?id=' . $row['id'] . '" class="btn btn-info btn-sm me-2">View</a>
    <form action="partials/usercode.php" class="d-inline" method="POST">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button class="btn btn-danger btn-sm" type="submit" name="delete_user">Delete</button>
    </form>
</td>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8" class="text-center">No catalog items found</td></tr>';
                                    }


                                    mysqli_close($conn);
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2020</span>
            </div>
        </div>
    </footer>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CONFORM </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>