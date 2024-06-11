<?php
    session_start();
    require_once '../php/connect.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/favourites.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Favourites</title>
</head>
<body>

    <button id="back_to_main"><i class="fas fa-arrow-left"></i> back</button>

        <script>
            document.getElementById("back_to_main").onclick = function() {
                window.location.href = "index.php";
            };
        </script>

    <div class="container">
        <?php
             if(isset($_SESSION['userid'])) {
                $userid = $_SESSION['userid'];
            } else {
                header('Location: favourites.php');
                exit;
            }


            $sql = "SELECT f.* FROM field f JOIN favorites fa ON f.id = fa.field_id WHERE fa.user_id = $userid";

            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="field" id="field">';
                    echo '<h2>'.$row["header"].'</h2>';
                    echo '<img class="field_image" id="field_image" src="'."../field_images/".$row["field_image"].'">';
                    echo '<p>Price: '.$row["price"].'</p>';
                    echo '<p>Phone Number: '.$row["phone_number"].'</p>';
                    echo '<p>City: '.$row["city"].'</p>';
                    echo '<input type="hidden" name="field_id" value="' . $row["id"] . '">';
   
                    echo '<form action="../php/delete_fav.php" method="post" enctype="">
                    <input type="hidden" name="field_id" value="'.$row["id"].'">
                    <input type="hidden" name="userid" value="'.$userid.'"> 
                    <button type="submit" class="" name="delete_fav" id="fav_button"> Delete from favourites <i class="fas fa-trash"></i></button>
                    </form>';

                    echo '</div>';
                }
            } else {
                echo "No favorite fields available.";
            }

            mysqli_close($connect);
        ?>
    </div>


    
</body>
</html>