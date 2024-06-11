<?php
    session_start();
    require_once 'connect.php';

    $email = $_POST['email'];
    $pass = md5($_POST['pass']); 

    $check_user = mysqli_query($connect, "SELECT id FROM users WHERE email = '$email' AND password = '$pass'");
        if (mysqli_num_rows($check_user) > 0) {
            $_SESSION ['logedin'] = 1;

            $userid = 0;

            while($row = $check_user->fetch_assoc()) {
                $userid = $row["id"];
            }

            $_SESSION ['userid'] = $userid;

            if($userid == 15){ //sprawdza czy loguje sie admin
                header('Location: ../html/admin.php');
                exit;
            } else {
                header('Location: ../html/index.php');
                exit;
            }

        } else {
            $_SESSION['message'] = 'Wrong email or password';
            header('Location: ../html/login.php');
            exit;
        }

    mysqli_close($connect);
?>
