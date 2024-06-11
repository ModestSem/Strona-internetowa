<?php
    session_start();
    require_once 'connect.php';

    if(isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];
    } else {
        header('Location: ../html/add_field.php');
        exit;
    }

    if(isset($_POST['upload'])){
        $header = $_POST['header'];
        $price = $_POST['price'];
        $phonenumber = $_POST['phonenumber'];
        $city = $_POST['city'];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "../field_images/" . $filename;

        $or_show = $_SESSION['or_show'] = 0;
        $or_fav = $_SESSION['of_fav'] = 0;
        

        mysqli_query($connect, "INSERT INTO `field` (`id`, `header`, `price`, `phone_number`, `field_image`, `user_id`, `or_show`, `city`, `or_fav`) VALUES (NULL, '$header', '$price', '$phonenumber', '$filename', '$userid', '$or_show', '$city', '$or_fav')");



        if (move_uploaded_file($tempname, $folder)) {
            header('Location: ../html/index.php');
            exit;
        } else {
            header('Location: ../html/add_field.php');
            exit;
        }
    }
?>
