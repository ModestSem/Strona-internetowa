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
    <title>Register</title>
</head>
<body>
    
      <div class="wrapper">
        <form action="../php/server_register.php" method="post" enctype="multipart/form-data">
          <h1>Create account</h1>
          <div class="input-box">
            <input type="text" placeholder="Username" name="username" required>
            <i class='bx bxs-user'></i>
          </div>
          <div class="input-box">
            <input type="email" placeholder="Email" name="email" required>
            <i class='bx bxs-envelope'></i>
          </div>
          <div class="input-box">
            <input type="password" placeholder="Password" name="pass" required>
            <i class='bx bxs-lock-alt' ></i>
          </div>
          <div class="input-box">
            <input type="password" placeholder="Confirm password" name="pass2" required>
            <i class='bx bxs-lock-alt' ></i>
          </div>
          
          <input class="input-avatar" type="file" name="avatar">
        
          <button type="submit" name="final_register" class="btn"> Register </button>
    
          <div class="register-link">
            <p> Already have an account? <a href="login.php"> Login </a></p>
          </div>
        </form>

        <?php
            if(isset($_SESSION['message'])){
                echo '<p>' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']);
            }
        ?>

        </div>

        <script>
          images();
       </script>
</body>
</html>