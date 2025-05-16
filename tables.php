<?php
session_start();
include("partials/database.php");
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
    <link rel="stylesheet" href="/css/style.css">


    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script>
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
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
            <li class="nav-item">
                <a class="nav-link" href="user_tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>User-table</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
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

            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

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
                <!--  Catalog Button -->
                <?php include('partials/database.php'); ?>
                <div class="text-right my-3 mr-3">
                    <button id="showFormBtn" class="btn btn-primary">Add Catalog</button>
                    <?php
                    $firstname = null;
                    $stock = null;
                    $price = null;
                    $description = null;
                    $success = null;
                    $image_path = null;
                    $upload0k = null;
                    $error = null;


                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $firstname  = $_POST['catalogname'] ?? '';
                        $stock  = $_POST['stock'];
                        $price  = $_POST['price'];
                        $description  = $_POST['description'] ?? '';
                        $hasError = false;

                        if (empty($firstname)) {
                            $error = "Name is required!";
                            $hasError = true;
                        }


                        if (!$hasError) {
                            $sql = "INSERT INTO catelog (catalog_name, stock, price, description, image_path, last_updated) VALUES (?, ?, ?, ?, ?, NOW())";
                            $stmt = mysqli_prepare($conn, $sql);
                            $target_dir = "uploads/";
                            if (!file_exists($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }
                            $target_file = $target_dir . basename($_FILES["catalogImage"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            // Check if image file is a actual image
                            $check = getimagesize($_FILES["catalogImage"]["tmp_name"]);
                            if ($check === false) {
                                $error = "File is not an image.";
                                $hasError = true;
                            }

                            // Check file size (2MB max)
                            if ($_FILES["catalogImage"]["size"] > 2000000) {
                                $error = "Sorry, your file is too large (max 2MB).";
                                $hasError = true;
                            }

                            // Allow certain file formats
                            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $hasError = true;
                            }

                            // Generate unique filename to prevent overwrites
                            $new_filename = uniqid() . '.' . $imageFileType;
                            $target_file = $target_dir . $new_filename;

                            // If everything is ok, try to upload file
                            if (!$hasError) {
                                // Image upload processing
                                $target_dir = "uploads/";
                                if (!file_exists($target_dir)) {
                                    mkdir($target_dir, 0777, true);
                                }
                                $target_file = $target_dir . basename($_FILES["catalogImage"]["name"]);
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                // Check if image file is a actual image
                                $check = getimagesize($_FILES["catalogImage"]["tmp_name"]);
                                if ($check === false) {
                                    $error = "File is not an image.";
                                    $hasError = true;
                                }

                                // Check file size (2MB max)
                                if ($_FILES["catalogImage"]["size"] > 2000000) {
                                    $error = "Sorry, your file is too large (max 2MB).";
                                    $hasError = true;
                                }

                                // Allow certain file formats
                                if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $hasError = true;
                                }

                                // Generate unique filename to prevent overwrites
                                $new_filename = uniqid() . '.' . $imageFileType;
                                $target_file = $target_dir . $new_filename;

                                // If everything is ok, try to upload file
                                if (!$hasError) {
                                    if (move_uploaded_file($_FILES["catalogImage"]["tmp_name"], $target_file)) {
                                        $image_path = $target_file;
                                    } else {
                                        $error = "Sorry, there was an error uploading your file.";
                                        $hasError = true;
                                    }
                                }

                                // Then proceed with your database insert
                                $sql = "INSERT INTO catelog (catalog_name, stock, price, description, image_path, last_updated) VALUES (?, ?, ?, ?, ?, NOW())";
                                // Rest of your database code...
                            }

                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "sidss", $firstname, $stock, $price, $description, $image_path);

                                try {
                                    if (mysqli_stmt_execute($stmt)) {
                                        $success = "Catalog item added successfully!";
                                        // Clear form or redirect
                                        echo "<script>document.getElementById('catalogFormBox').style.display='none';</script>";
                                    } else {
                                        $error = "Error executing query: " . mysqli_error($conn);
                                    }
                                } catch (mysqli_sql_exception $e) {
                                    $error = "Database error: " . $e->getMessage();
                                }

                                mysqli_stmt_close($stmt);
                            } else {
                                $error = "Error preparing statement: " . mysqli_error($conn);
                            }
                        }
                    }


                    // Display success/error messages
                    if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>


                    <!-- Floating Form Box -->
                    <div id="catalogFormBox" class="form-box">
                        <form method="POST" id="catalogForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <h3>Add Catalog Item</h3>
                            <input type="text" name="catalogname" placeholder="Catalog Name" required>
                            <input type="number" name="stock" placeholder="Stock">
                            <input type="number" name="price" placeholder="Price" min="0" required>
                            <input type="text" name="description" placeholder="Description">
                            <div class="form-group rightround">
                                <label for="catalogImage">Product Image</label>
                                <input type="file" name="catalogImage" id="catalogImage" accept="image/*">
                                <small class="form-text text-muted">Max size: 2MB (JPEG, PNG, GIF)</small>
                            </div>
                            <div class="form-buttons">
                                <button type="submit">Save</button>
                                <button type="button" id="cancelFormBtn">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Styles -->
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

                    <!-- JavaScript -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const showBtn = document.getElementById('showFormBtn');
                            const formBox = document.getElementById('catalogFormBox');
                            const cancelBtn = document.getElementById('cancelFormBtn');

                            showBtn.addEventListener('click', () => {
                                formBox.style.display = 'block';
                                formBox.querySelector('input[name="catalogname"]').focus();
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
                        <h6 class="m-0 font-weight-bold text-primary">Catalog Items</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Database connection (make sure you have this already)
                                    include_once("partials/database.php");


                                    // Query to get all catalog items
                                    $sql = "SELECT * FROM catelog ";
                                    $result = mysqli_query($conn, $sql);

                                    // Check if there are results
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>';
                                            echo '<td>' . $row['catalog_id'] . '</td>';
                                            echo '<td>' . $row['catalog_name'] . '</td>';
                                            echo '<td>' . $row['price'] . '</td>';
                                            echo '<td>' . ($row['image_path'] ? '<img class="rounded-circle" width="50" height="50" src="' . $row['image_path'] . '" width="50">' : 'No image') . '</td>';
                                            echo '<td>' . substr($row['description'], 0, 330) . '...</td>';
                                            echo '<td>' . $row['stock'] . '</td>';
                                            echo '<td>' . ($row['stock'] > 0 ? 'available' : 'not available') . '</td>';
                                            echo '<td>' . $row['last_updated'] . '</td>';
                                            echo '<td>
    <a href="student-edit.php?id=' . $row['catalog_id'] . '" class="btn btn-primary btn-sm me-2">Edit</a>
    <a href="student-view.php?id=' . $row['catalog_id'] . '" class="btn btn-info btn-sm me-2">View</a>
    <form action="partials/code.php" class="d-inline" method="POST">
        <input type="hidden" name="catalog_id" value="' . $row['catalog_id'] . '">
        <button class="btn btn-danger" type="submit" name="delete_product">Delete</button>
    </form>
</td>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8" class="text-center">No catalog items found</td></tr>';
                                    }

                                    // Close connection
                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                                <!-- Remove the tfoot section as it's not needed for displaying data -->
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