<?php
    session_start();
    require_once '../php/connect.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Admin</title>
</head>
<body>
    
    <?php
         $userid = $_SESSION['userid'];

         $sql = "SELECT avatar, username FROM Users WHERE user_id = ".$userid;
         $result = $connect->query($sql);
   
         if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
             echo '<div id="profile-container" class="section">';
             echo '<div class="user-info">';
             echo '<img id="avatar" src="'."../avatars/".$row["avatar"].'" alt="User Avatar">';
             echo '<p id="username">'.$row["username"].'</p>';
             echo '</div>';
   
             echo '<form action="../php/server_logout.php" method="post" class="logout-form">';
             echo '<button type="submit" name="logout_btn">Log Out <i class="bx bx-log-in"></i> </button>'; // Dodanie ikony Google do przycisku
             echo '</form>';
   
             echo '</div>'; // Zamknięcie profile-container

             $sql = "SELECT l.listing_id, l.title, l.description, l.price, l.location, l.city, GROUP_CONCAT(i.image_url) AS images
             FROM Listings l 
             LEFT JOIN Images i ON l.listing_id = i.listing_id 
             WHERE l.approved = 0
             GROUP BY l.listing_id";

             $resultListings = $connect->query($sql);

             if ($resultListings->num_rows > 0) {
                 while($rowListing = $resultListings->fetch_assoc()) {
                    
                     // Wyświetlenie informacji ogłoszenia tylko raz
                     echo "<div class='listing-container'>";
                     echo "<h2>" . $rowListing['title'] . "</h2>";
                     echo "<p>Description: " . $rowListing['description'] . "</p>";
                     echo "<p>Price: $" . $rowListing['price'] . "</p>";
                     echo "<p>Location: " . $rowListing['location'] . "</p>";
                     echo "<p>City: " . $rowListing['city'] . "</p>";

                     // Wyświetlenie obrazków, jeśli są dostępne
                     if ($rowListing['images'] != null) {
                         $images = explode(',', $rowListing['images']);
                         foreach ($images as $image) {
                             echo '<img src="../field_images/' . $image . '" alt="Listing Image">';
                         }
                     }

                     echo '<form action="../php/server_admin.php" method="post">';
                     echo '<input type="hidden" name="listing_id" value="' . $rowListing['listing_id'] . '">';
                     echo '<button type="submit" name="accept"><i class="fas fa-check"></i> Accept</button>';
                     echo '<button type="submit" name="reject"><i class="fas fa-times"></i> Reject</button>';
                     echo '</form>';

                     echo "</div>"; // Zamknięcie listing-container

                     echo "<hr>";
                 }
             } else {
                 echo "No fields available.";
             }
           }
         }
    ?>
</body>
</html>
