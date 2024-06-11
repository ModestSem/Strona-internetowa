<?php
    session_start();
    require_once '../php/connect.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/my_fields.css">
    <title>My fields</title>
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
                header('Location: my_fields.php');
                exit;
            }

            $sql = "SELECT * FROM field WHERE user_id = $userid";
            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="field" id="field">';
                    echo '<h2>'.$row["header"].'</h2>';
                    echo '<img class="field_image" id="field_image" src="'."../field_images/".$row["field_image"].'">';
                    echo '<p>Price: '.$row["price"].'</p>';
                    echo '<p>Phone Number: '.$row["phone_number"].'</p>';
                    echo '<p>City: '.$row["city"].'</p>';
                    echo '<button onclick="window.location.href=\'edit_field.php?field_id=' . $row["id"] . '\'">Edit  <i class="fas fa-pencil-alt"></i></button>';
                    echo'<form action="../php/delete_field.php" method="post">';
                    echo '<input type="hidden" name="field_id" value="' . $row["id"] . '">';
                    echo'<button type="submit" name="delete_btn">Delete  <i class="fas fa-trash"></i></button>';
                    echo'</form>';
                    echo '</div>';
                }
            } else {
                echo "No fields available";
            }

            mysqli_close($connect);
        ?>
    </div>
    
</body>
</html>
