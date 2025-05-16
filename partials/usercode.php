<?php
session_start();
include('database.php');
// Also make sure session is started





if (isset($_POST['delete_user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if the ID exists in the database
    $check_query = "SELECT * FROM ecommerce WHERE id='$id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Proceed with deletion if user exists
        $delete_query = "DELETE FROM ecommerce WHERE id='$id'";
        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            // Success: Set session alert for successful deletion
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'User deleted successfully'
            ];
        } else {
            // Failure: Set session alert for failure in deletion
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Failed to delete user: ' . mysqli_error($conn)
            ];
        }
    } else {
        // User ID not found in database
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'User not found.'
        ];
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

if (isset($_POST['update_user'])) {
    // Sanitize form inputs
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Only proceed if ID is provided
    if (!empty($id)) {
        // Check if user exists
        $check_query = "SELECT * FROM ecommerce WHERE id = '$id'";
        $result = mysqli_query($conn, $check_query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Build update query
            $update_query = "UPDATE ecommerce SET
firstname = '$firstname',
lastname = '$lastname',
email = '$email',
address = '$address'";


            // Only update password if it's not empty
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_query .= ", password = '$hashed_password'";
            }

            $update_query .= " WHERE id = '$id'";

            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => 'User updated successfully'
                ];
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Failed to update user: ' . mysqli_error($conn)
                ];
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'User not found.'
            ];
        }
    } else {
        $_SESSION['error'] = "Invalid user ID.";
    }

    header('Location: ../user_tables.php');
    exit();
}
