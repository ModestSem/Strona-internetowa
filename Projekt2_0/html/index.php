<?php
  session_start();
  require_once '../php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link rel="stylesheet" href="../css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
</head>
<body>
  
    <?php
      
        if(isset($_SESSION['logedin'])){
  echo' <div  class="wrapper" id="wrapper">';

          $userid = $_SESSION['userid'];

          $sql = "SELECT avatar, username FROM users WHERE id = ".$userid;
          $result = $connect->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              
              echo '<img id="avatar" src="'."../avatars/".$row["avatar"].'">';
              echo '<p id="username">'.$row["username"].'</p>';
            }
          }

            echo '<form action="favourites.php">
            <button type="submit" class="button" id="addfield_button"> Favorites    <i class="fas fa-heart"></i> </button>
            </form> ';

            echo '<form action="add_field.php">
            <button type="submit" class="button" id="addfield_button"> Add Field <i class="fas fa-plus"></i></button>
            </form> ';

            echo '<form action="my_fields.php">
            <button type="submit" class="button" id="my_fields_button"> My fields   <i class="fas fa-file-alt"></i></button>
            </form> ';
            
            echo '  <form action="../php/logout.php" method="" enctype="">
            <button type="submit" class="button" id="logout_button"> Log Out <i class="fas fa-sign-out-alt"></i></button>
            </form>';
    echo'</div>';
           
    ?>


  <div class="container">
    <?php
    
    
          $sql = "SELECT * FROM field WHERE or_show = 1";
          $result = $connect->query($sql);
  
          if ($result->num_rows > 0) {
              // Wyświetl produkty
              while($row = $result->fetch_assoc()) {
                  echo '<div class="field" id="field">';
                  echo '<h2>'.$row["header"].'</h2>';
                  echo '<img class="field_image" id="field_image" src="'."../field_images/".$row["field_image"].'">';
                  echo '<p>Price: '.$row["price"].'</p>';
                  echo '<p>Phone Number: '.$row["phone_number"].'</p>';
                  echo '<p>City: '.$row["city"].'</p>';

                  echo '<form action="../php/favourite.php" method="post" enctype="">
                  <input type="hidden" name="field_id" value="'.$row["id"].'">
                  <button type="submit" class="fav_button" name="or_fav" id="fav_button">
                      <i class="fas fa-heart"></i> 
                  </button>
                  </form>';

                  echo '</div>';
              }
          } else {
              echo "No products available";
          }
  
          mysqli_close($connect);

        } 
        
    ?>
  </div>

        <?php 


          if(!isset($_SESSION['logedin'])){ 

  echo ' <div  class="wrapper" id="wrapper">';

              echo '<img id="avatar" src="../avatars/guest.jpeg">';
              echo '<p id="username_guest">Guest</p>';

        
              echo '<form action="login.php" method="" enctype="">
              <button type="submit" class="button" id="register_button"> Login </button>
              </form>';
  echo '</div>';

          ?>

    
  <div class="container">
        <?php
              $sql = "SELECT * FROM field WHERE or_show = 1";
              $result = $connect->query($sql);
      
              if ($result->num_rows > 0) {
                  // Wyświetl produkty
                  while($row = $result->fetch_assoc()) {
                      echo '<div class="field" id="field">';
                      echo '<h2>'.$row["header"].'</h2>';
                      echo '<img class="field_image" id="field_image" src="'."../field_images/".$row["field_image"].'">';
                      echo '<p>Price: '.$row["price"].'</p>';
                      echo '</div>';
                  }
              } else {
                  echo "No products available";
              }
      
              mysqli_close($connect);
            }
          ?>
  </div>
    
</body>
</html>