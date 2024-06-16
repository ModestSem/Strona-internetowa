<?php
    session_start();
    require_once 'connect.php'; 

    if(isset($_POST['delete_field_btn'])) { //Button "Delete" zostal wcisniety
        if(isset($_POST['listing_id']) && !empty($_POST['listing_id'])) { //id ogloszenia jest ustawiony i nie jest pusty
            $listing_id = $_POST['listing_id']; 

            $delete_images_sql = "DELETE FROM Images WHERE listing_id = $listing_id"; //Odrazu usuwamy obrazki aby nie bylo bledu
            $delete_listing_sql = "DELETE FROM Listings WHERE listing_id = $listing_id";

            if (mysqli_query($connect, $delete_images_sql)) {
                if (mysqli_query($connect, $delete_listing_sql)) {
                    header('Location: ../html/my_fields.php'); // Przekierowanie do strony admina po usunięciu
                    exit;
                } else {
                    echo "Error deleting images: " . mysqli_error($connect);
                    exit;
                }
            } else {
                echo "Error deleting listing: " . mysqli_error($connect);
                exit;
            }
        } else {
            echo "Error: No listing_id.";
            exit;
        }
    } else {
        echo "Error: No delete action.";
        exit;
    }

    $connect->close();
?>
