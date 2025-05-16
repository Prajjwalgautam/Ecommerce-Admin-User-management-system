<?php
session_start();


if (isset($_POST['delete_product'])) {
    include_once("database.php");

    $catalog_id = mysqli_real_escape_string($conn, $_POST['catalog_id']);
    $delete_query = "DELETE FROM catelog WHERE catalog_id='$catalog_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Product deleted successfully'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Failed to delete product: ' . mysqli_error($conn)
        ];
    }

    header("Location:../tables.php");
    exit();
}






require_once("database.php");

if (isset($_POST['update_product'])) {

    $catalog_id = mysqli_real_escape_string($conn, $_POST['catalog_id']);
    $catalog_name = mysqli_real_escape_string($conn, $_POST['catalog_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);


    $image_path = null;
    $uploadOk = 1;

    // Check if file is uploaded
    if (isset($_FILES['catalogImage']) && $_FILES['catalogImage']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../images/";
        $image_path = time() . '_' . basename($_FILES["catalogImage"]["name"]);
        $target_file = $target_dir . $image_path;
        $image_path_db = 'images/' . $image_path;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES["catalogImage"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "File is not a valid image."
            ];
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["catalogImage"]["size"] > 2000000) {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "Sorry, your file is too large (max 2MB)."
            ];
            $uploadOk = 0;
        }


        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "Only JPG, JPEG, PNG & GIF files are allowed."
            ];
            $uploadOk = 0;
        }


        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["catalogImage"]["tmp_name"], $target_file)) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "There was an error uploading your file."
                ];
                header('Location: ../tables.php');
                exit();
            }
            $image_path = $image_path_db;
        }
    }


    if ($image_path) {
        $query = "UPDATE catelog SET 
                 catalog_name = '$catalog_name',
                 price = '$price',
                 image_path = '$image_path',
                 description = '$description',
                 stock = '$stock'
                 WHERE catalog_id = '$catalog_id'";
    } else {
        $query = "UPDATE catelog SET 
                 catalog_name = '$catalog_name',
                 price = '$price',
                 description = '$description',
                 stock = '$stock'
                 WHERE catalog_id = '$catalog_id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Product updated successfully'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Failed to update product: ' . mysqli_error($conn)
        ];
    }

    header('Location: ../tables.php');
    exit();
}
?>


//for user delete