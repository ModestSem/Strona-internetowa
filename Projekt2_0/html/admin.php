<?php
    session_start();
    require_once '../php/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
        
<div class="wrapper">

    <?php
        $userid = $_SESSION['userid'];

        $sql = "SELECT avatar, username FROM users WHERE id = ".$userid;
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                echo '<div class="avatar-container">';
                echo '<img id="avatar" src="'."../avatars/".$row["avatar"].'">';
                echo '</div>';
                echo '<p id="username">'.$row["username"].'</p>';
            }
        }

        echo'<form action="../php/logout.php" method="POST">
        <button type="submit" class="button" id="logout_button"> Log Out <i class="fas fa-sign-out-alt"></i></button>
        </form>';
    ?>
</div>

<div class="container">
    <?php
        $sql = "SELECT * FROM field WHERE or_show = 0";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            // Wyświetl produkty
            while($row = $result->fetch_assoc()) {
                echo '<div class="field" id="field">';
                echo '<h2>'.$row["header"].'</h2>';
                echo '<img class="field_image" id="field_image" src="'."../field_images/".$row["field_image"].'">';
                echo '<p>Price: '.$row["price"].'</p>';
                echo '<p>Phone Number: '.$row["phone_number"].'</p>';
                echo '<form action="../php/server_admin.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="field_id" value="'.$row["id"].'">
                        <button type="submit" name="accept" class="button">Accept</button>
                        <button type="submit" name="reject" class="button reject-button">Reject</button>
                      </form>';
                echo '</div>';
            }
        } else {
            echo "There are no new fields.";
        }

        mysqli_close($connect);
    ?>
</div>

</body>
</html>
