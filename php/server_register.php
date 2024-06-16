<?php
    session_start();
    require_once 'connect.php';

    //pobieranie danych
    $username = $_POST['username'];
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $phonenumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    //Sprawdza czy jest najmniej 6 symboli w hasle
    if(strlen($pass) >= 6){
        //heszuje haslo
        if($pass === $pass2){
            $pass = md5($pass);
        } 
        else { //Jezeli hasla sa niejednakowe
            $_SESSION['login_message'] = 'Passwords do not match!';
            header('Location: ../html/register.php');
            exit;
        }
    } 
    else { //Jezeli haslo ma mniej 6 symboli
        $_SESSION['login_message'] = 'The password must be at least 6 characters long!';
        header('Location: ../html/register.php');
        exit;
    }

    if(isset($_POST['register_btn'])){

        // Sprawdzenie, czy użytkownik już istnieje
        $query = "SELECT * FROM `Users` WHERE `username` = '$username' OR `email` = '$email'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            // Użytkownik już istnieje
            $_SESSION['login_message'] = 'User with this username or email already exists!';
            header('Location: ../html/register.php');
            exit;

            //Jezeli nie istnieje
        } else {
            $avatar = $_FILES['avatar'];
            $avatarName = $avatar['name'];
            $avatarType = $avatar['type'];
            $avatarTmpName = $avatar['tmp_name'];
            $avatarError = $avatar['error'];
            $avatarSize = $avatar['size'];

            //dopuszczalny format pliku
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

            //avatar nie wiekszy niz 40 KB
            if ($avatarSize < 40097152){
                if(in_array($file_ext, $allowed_ext)) { //Sprawdzenie czy avatar odpowiada $allowed_ext
                    $newAvatarName = $username . "." . $file_ext; //123123.jpg -> username.jpg
                    $avatarDestination = "../avatars/" . $newAvatarName; //Tworzenie sciezki oraz 
                    
                    //Dodanie user'a do bazy
                    $query = "INSERT INTO `Users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `avatar`) VALUES (NULL, '$username', '$pass', '$email', '$firstname', '$lastname', '$phonenumber', '$newAvatarName')";
                    if (mysqli_query($connect, $query)) {

                        move_uploaded_file($avatarTmpName, $avatarDestination); //Dodanie obrazka do folderu avatars
                        $_SESSION['login_message'] = 'Register successful!'; //komunikat o udanej rejestracji
                        header('Location: ../html/login.php');
                        exit;
                    }
                    else {
                        $_SESSION['login_message'] = 'Error register'; //komunikat o nie udanej rejestracji
                        header('Location: ../html/register.php');
                        exit;
                    }
                } 
                else {
                    $_SESSION['login_message'] = 'Unsupported file format!';
                    header('Location: ../html/register.php');
                    exit;
                }
            } 
            else {
                $_SESSION['login_message'] = 'Large file!';
                header('Location: ../html/register.php');
                exit;
            }
        }
    }

?>





