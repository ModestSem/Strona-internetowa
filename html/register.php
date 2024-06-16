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
    <title>Register</title>
</head>
<body>

<div class="wrapper">
    <h1>Register</h1>
        <form action="../php/server_register.php" method="post" enctype="multipart/form-data">
       
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" >
            </div>
            <div class="input-box">  
                <input type="text" placeholder="First Name" name="firstName">
            </div>
            <div class="input-box">
                <input type="text" placeholder="Last Name" name="lastName" >        
            </div>
            <div class="input-box">
                <input type="text" placeholder="Phone number" name="phoneNumber" >  
            </div>
            <div class="input-box">
                <input type="email" placeholder="Email" name="email" >
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="pass" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="pass2" required>
            </div>

                <input class="input-avatar" type="file" name="avatar">
       
            <button type="submit" name="register_btn" class="btn"> Register </button>

        </form>

    
        <div class="register-link">
            <p> Already have an account? <a href="login.php"> Login </a></p>
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