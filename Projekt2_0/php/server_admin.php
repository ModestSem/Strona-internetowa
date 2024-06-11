<?php
    session_start();
    require_once 'connect.php';

    if(isset($_POST['accept'])){
        if(isset($_POST['field_id'])){
            $field_id = $_POST['field_id'];
        
            $sql = "UPDATE field SET or_show = 1 WHERE id = $field_id";
            $result = mysqli_query($connect, $sql);


            if($result){
                header('Location: ../html/admin.php');
            } else {
                echo("Error");
            }
        }
    }


    //Usuniecie fieldu
    if(isset($_POST['reject']) && isset($_POST['field_id'])){
        $field_id = $_POST['field_id'];

        $sql = "DELETE FROM field WHERE id = $field_id";
        if ($connect->query($sql) === TRUE) {
            header('Location: ../html/admin.php');
            exit;
        } else {
            header('Location: ../html/admin.php');
            exit;
        }
    }
?>