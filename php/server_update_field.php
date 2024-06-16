<?php
    session_start();
    require_once 'connect.php';

    if (isset($_POST['update_field_btn'])) {
        $listing_id = $_POST['listing_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $location = $_POST['location'];
        $city = $_POST['city'];

        $sql = "UPDATE Listings SET 
                title = '$title', 
                description = '$description', 
                price = '$price', 
                location = '$location', 
                city = '$city',
                approved = 0
                WHERE listing_id = $listing_id";

        if (mysqli_query($connect, $sql)) {
            header('Location: ../html/edit_my_field.php'); 
            $_SESSION['update_field'] = 'Field updated successfully and sent to admin for review.';
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($connect);
        }
    } else {
        echo "Error: No update action.";
    }

    $connect->close();
?>
