<?php
    session_start();
    require_once 'connect.php';

    //pobieranie danych
    $username = $_POST['username'];
    $phonenumber = $_POST['phoneNumber'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $userid = $_SESSION['userid']; // Pobranie user_id z sesji

    //Sprawdza czy jest 6 symboli
    if(strlen($pass) >= 6 && strlen($pass2) >= 6){
        //heszuje haslo
        if($pass === $pass2){
            $pass = md5($pass);
        } 
        else {
            $_SESSION['editprofile_message'] = 'Passwords do not match!';
            header('Location: ../html/edit_profile.php');
            exit;
        }
    } 
    else {
        $_SESSION['editprofile_message'] = 'The password must be at least 6 characters long!';
        header('Location: ../html/edit_profile.php');
        exit;
    }

    //akceptowane formaty avatara
    $avatar = $_FILES['avatar'];
            $avatarName = $avatar['name'];
            $avatarType = $avatar['type'];
            $avatarTmpName = $avatar['tmp_name'];
            $avatarError = $avatar['error'];
            $avatarSize = $avatar['size'];

            $allowed_ext = array(
                'png',
                'bmp',
                'jpg',
                'jpeg',
                'JPG',
                'PNG',
                'JPEG'
            ); 

            $file_ext = strtolower(pathinfo($avatarName, PATHINFO_EXTENSION)); //pobiera format avatara

    if(isset($_POST['update_profile_btn'])){

        if ($avatarSize < 40097152){ //Sprawdza rozmiar <40KB
            if(in_array($file_ext, $allowed_ext)) {
                $newAvatarName = $username . "." . $file_ext; //123123.jpg -> username.jpg
                $avatarDestination = "../avatars/" . $newAvatarName;

                $query = "UPDATE Users SET username = '$username', phone_number = '$phonenumber', password = '$pass', avatar = '$newAvatarName' WHERE user_id = '$userid'";

                if (mysqli_query($connect, $query)) {

                    move_uploaded_file($avatarTmpName, $avatarDestination);
                    $_SESSION['editprofile_message'] = 'Profile updated successfully!';
                    header('Location: ../html/edit_profile.php');
                    exit;

                } else {
                    $_SESSION['editprofile_message'] = 'Error updating profile: ' . mysqli_error($connect);
                    header('Location: ../html/edit_profile.php');
                    exit;
                }

            } else {
                $_SESSION['editprofile_message'] = 'Unsupported file format!';
                header('Location: ../html/edit_profile.php');
                exit;
            }
        } else {
            $_SESSION['editprofile_message'] = 'Large file!';
            header('Location: ../html/edit_profile.php');
            exit;
        }
    }
?>