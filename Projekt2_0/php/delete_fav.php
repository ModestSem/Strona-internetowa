<?php

    session_start();
    require_once 'connect.php';

    if(isset($_POST['delete_fav']) && isset($_POST['field_id']) && isset($_POST['userid'])){
        $field_id = $_POST['field_id'];
        $user_id = $_POST['userid'];

        // Usunięcie rekordu z tabeli favorites
        $delete_sql = "DELETE FROM favorites WHERE field_id = $field_id AND user_id = $user_id";
        $delete_result = mysqli_query($connect, $delete_sql);

        // Aktualizacja kolumny or_fav w tabeli field
        $update_sql = "UPDATE field SET or_fav = 0 WHERE id = $field_id";
        $update_result = mysqli_query($connect, $update_sql);

        if($delete_result && $update_result){
            header('Location: ../html/favourites.php');
        } else {
            echo("Error");
        }

    }

?>
