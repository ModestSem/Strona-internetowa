<?php
session_start();
require_once 'connect.php';

$name = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];

if ($pass === $pass2) {
    $pass = md5($pass);
} else {
    $_SESSION['message'] = 'Passwords do not match!';
    header('Location: ../html/register.php');
    exit;
}

if (isset($_POST["final_register"])) {

    // Sprawdzenie, czy użytkownik już istnieje
    $query = "SELECT * FROM `users` WHERE `username` = '$name' OR `email` = '$email'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Użytkownik już istnieje
        $_SESSION['message'] = 'User with this username or email already exists!';
        header('Location: ../html/register.php');
        exit;
    } else {
        $avatar_name = $_FILES["avatar"]["name"];
        $tmp_avatar = $_FILES["avatar"]["tmp_name"];
        $folder = "../avatars/" . $avatar_name;

        // Próbujemy wstawić użytkownika do bazy danych
        $query = "INSERT INTO `users` (`id`, `username`, `password`, `email`, `avatar`) VALUES (NULL, '$name', '$pass', '$email', '$avatar_name')";
        if (mysqli_query($connect, $query)) {
            // Jeżeli użytkownik został pomyślnie dodany do bazy, próbujemy przesłać plik
            if (move_uploaded_file($tmp_avatar, $folder)) {
                $_SESSION['message'] = 'Register successful!';
                header('Location: ../html/login.php');
                exit;
            } else {
                $_SESSION['message'] = 'Failed to upload avatar!';
                header('Location: ../html/register.php');
                exit;
            }
        } else {
            // Obsługa błędów zapytania SQL
            $_SESSION['message'] = 'Database error: ' . mysqli_error($connect);
            header('Location: ../html/register.php');
            exit;
        }
    }
}
?>
