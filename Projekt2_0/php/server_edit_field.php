<?php
    session_start();
    require_once '../php/connect.php';

    if (isset($_POST['update_btn'])) {
        $field_id = $_POST['field_id'];
        $header = $_POST['header'];
        $price = $_POST['price'];
        $phone_number = $_POST['phone_number'];
        $city = $_POST['city'];

        $sql = "UPDATE field SET header = '$header', price = '$price', phone_number = '$phone_number', city = '$city' WHERE id = $field_id";
        
        if ($connect->query($sql) === TRUE) {
            header('Location: ../html/my_fields.php');
        } else {
            echo "Error updating record: " . $connect->error;
        }
    }

    if(isset($_POST['back_btn'])){
        header('Location: ../html/my_fields.php');
    }
?>
