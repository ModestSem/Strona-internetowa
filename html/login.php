<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="../background/images.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="wrapper">
        <h1>Login</h1>

        <form action="../php/server_login.php" method="post">
            <div class="input-box">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="pass" required>
            </div>
            <button type="submit" name="login_btn" class="btn"> Login </button>
        </form>

        <div class="register-link">
            <p> Do'nt have an account?<a href="register.php"> Register </a></p>
        </div>

        <?php
            if(isset($_SESSION['login_message'])){
                echo '<p>' . $_SESSION['login_message'] . '</p>';
                unset($_SESSION['login_message']);
            }
        ?>

    </div>

    <script>
        images();
    </script>
</body>
</html>