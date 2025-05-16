<?php

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in");
}

$user_id = $_SESSION['user_id'];


$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = $conn->real_escape_string($_POST['firstname'] ?? '');
    $lastname = $conn->real_escape_string($_POST['lastname'] ?? '');
    $number = $conn->real_escape_string($_POST['number'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $address = $conn->real_escape_string($_POST['address'] ?? '');
    $country = $conn->real_escape_string($_POST['country'] ?? '');


    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profiles/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $file_name = 'profile_' . $user_id . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (
            in_array(strtolower($file_ext), $allowed_types) &&
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path)
        ) {
            $profile_image = $file_path;
        }
    }


    $check_sql = "SELECT id FROM adminprofile WHERE user_id = '$user_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {

        if ($profile_image) {
            $sql = "UPDATE adminprofile SET 
                    firstname='$firstname', 
                    lastname='$lastname', 
                    number='$number', 
                    email='$email', 
                    address='$address', 
                    country='$country', 
                    profile_image='$profile_image' 
                    WHERE user_id='$user_id'";
        } else {
            $sql = "UPDATE adminprofile SET 
                    firstname='$firstname', 
                    lastname='$lastname', 
                    number='$number', 
                    email='$email', 
                    address='$address', 
                    country='$country' 
                    WHERE user_id='$user_id'";
        }
    } else {

        $sql = "INSERT INTO adminprofile 
                (user_id, firstname, lastname, number, email, address, country, profile_image) 
                VALUES 
                ('$user_id', '$firstname', '$lastname', '$number', '$email', '$address', '$country', " .
            ($profile_image ? "'$profile_image'" : "NULL") . ")";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "Profile saved successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}


$sql = "SELECT * FROM adminprofile WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$profile = $result->fetch_assoc();

$user_sql = "SELECT * FROM ecommerce WHERE id = '$user_id'";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();
