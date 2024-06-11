<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/login.css">
    <script src="../Images/images.js"></script>
    <title>Login</title>
    
</head>
<body>
    <div class="wrapper">
        <form action="../php/server_login.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="email" placeholder="Email" name="email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="pass" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            
            <button type="submit" class="btn"> Login </button>

            <div class="register-link">
                <p> Do'nt have an account?<a href="register.php"> Register </a></p>
            </div>

            <?php
                if(isset($_SESSION['message'])){
                    echo '<p>' . $_SESSION['message'] . '</p>';
                    unset($_SESSION['message']);
                }
            ?>
        </form>
    </div>

    <script>
        images();
    </script>
</body>
</html>