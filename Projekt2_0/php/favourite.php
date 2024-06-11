<?php
session_start();
require_once 'connect.php';


    if (isset($_POST['field_id'])) {
        $field_id = $_POST['field_id'];
        $user_id = $_SESSION['userid'];

        $sql1 = "INSERT INTO `favorites` (`user_id`, `field_id`) VALUES ('$user_id', '$field_id')";
        $result1 = mysqli_query($connect, $sql1);


        if ($result1) {
            $sql2 = "UPDATE field SET or_fav = 1 WHERE id = $field_id";
            $result2 = mysqli_query($connect, $sql2);

            if ($result2) {
                header('Location: ../html/index.php');
            } else {
                echo "Błąd podczas aktualizacji pola.";
            }
        } else {
            echo "Błąd podczas dodawania do ulubionych.";
        }
    } else {
        echo "ID pola nie ustawione.";
    }
 
?>
