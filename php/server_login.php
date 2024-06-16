<?php
    session_start();
    require_once 'connect.php';

    //Pobieranie danych
    $email = $_POST['email'];
    $pass = md5($_POST['pass']); 

    //Sprawdzenie czy uzer istnieje
    $check_user = mysqli_query($connect, "SELECT user_id FROM Users WHERE email = '$email' AND password = '$pass'");
        if (mysqli_num_rows($check_user) > 0) {
            $_SESSION ['logedin'] = 1; //Ustawianie zmiennej globalnej na zalogowany (1)

            while($row = $check_user->fetch_assoc()) {
                $userid = $row["user_id"];  //wpisujemy do zmiennej $userid - id uzytkownika
                $_SESSION ['userid'] = $userid;
            }

            $query = "UPDATE Users SET last_login = CURRENT_TIMESTAMP WHERE user_id = $userid"; //obnawiamy last_login

            if(mysqli_query($connect, $query) && $userid != 1){ //Jezeli nie admin
                header('Location: ../html/index.php');
                exit;
            } else { //Jezeli admin
                header('Location: ../html/admin.php');
            }

        } else { //Jezeli dane sa nie praiwdlowe
            $_SESSION['login_message'] = 'Wrong email or password';
            header('Location: ../html/login.php');
            exit;
        }

    mysqli_close($connect);
?>



