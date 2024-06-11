<?php
    session_start();
    require_once 'connect.php';

    if(isset($_POST['delete_btn']) && isset($_POST['field_id'])) {
        $field_id = $_POST['field_id'];


        $sql2 = "DELETE FROM favorites WHERE field_id = $field_id";
        $result2 = $connect->query($sql2);

      
        $sql = "DELETE FROM field WHERE id = $field_id";
        $result = $connect->query($sql);


        if ($result2 === TRUE && $result === TRUE) {
            header('Location: ../html/my_fields.php');
            exit;
        } else {
            echo "Error: " . $connect->error; 
            exit;
        }
    }

    mysqli_close($connect);
?>
