<?php
    session_start();
    require_once 'connect.php';

    if(isset($_POST['accept'])){
        if(isset($_POST['listing_id']) && !empty($_POST['listing_id'])) {
            $listing_id = $_POST['listing_id'];

            // Zaktualizuj pole 'approved' w tabeli Listings na 1 dla danego listing_id
            $sql = "UPDATE Listings SET approved = 1 WHERE listing_id = $listing_id";

            if (mysqli_query($connect, $sql)) {
                header('Location: ../html/admin.php');
                exit;
            } else {
                echo "Error updating record: " . mysqli_error($connect);
                exit;
            }
        } else {
            echo "Error: No listing_id.";
            exit;
        }
    }

    if (isset($_POST['reject'])){
        if(isset($_POST['listing_id']) && !empty($_POST['listing_id'])) {
            $listing_id = $_POST['listing_id'];

            $delete_images_sql = "DELETE FROM Images WHERE listing_id = $listing_id";
            $delete_listing_sql = "DELETE FROM Listings WHERE listing_id = $listing_id";

            $error = false;

            if (mysqli_query($connect, $delete_images_sql)) {
                if (mysqli_query($connect, $delete_listing_sql)) {
                    mysqli_commit($connect);
                    header('Location: ../html/admin.php');
                    exit;
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }

            if ($error) {
                mysqli_rollback($connect);
                echo "Error deleting record: " . mysqli_error($connect);
                exit;
            }
        } else {
            echo "Error: No listing_id provided.";
            exit;
        }
    }
?>
