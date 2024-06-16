<?php
    session_start();
    require_once '../php/connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fields</title>
    <link rel="stylesheet" href="../css/my_fields.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<body>

    <div class="menu">
        <p><a href="index.php"> <i class="fas fa-arrow-left"></i> Back </a></p>
    </div>

    <div class="container">
        <h1>My Fields</h1>

        <div class="fields-list">
            <?php
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];

                    $sql = "SELECT l.listing_id, l.title, l.description, l.price, l.location, l.city, l.user_id, u.avatar, u.username, GROUP_CONCAT(i.image_url) AS images
                            FROM Listings l 
                            LEFT JOIN Users u ON l.user_id = u.user_id
                            LEFT JOIN Images i ON l.listing_id = i.listing_id 
                            WHERE l.user_id = $userid
                            GROUP BY l.listing_id";

                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="field">';
                            echo '<h2>' . $row['title'] . '</h2>';
                            echo '<p>Description: ' . $row['description'] . '</p>';
                            echo '<p>Price: $' . $row['price'] . '</p>';
                            echo '<p>Location: ' . $row['location'] . '</p>';
                            echo '<p>City: ' . $row['city'] . '</p>';

                            // Display images if available
                            if ($row['images'] != null) {
                                $images = explode(',', $row['images']);
                                foreach ($images as $image) {
                                    echo '<img src="../field_images/' . $image . '" alt="Listing Image">';
                                }
                            }

                            // Edit and Delete buttons with Font Awesome icons
                            echo '<div class="button-container">';
                            echo '<form action="../php/server_delete_listing.php" method="post">';
                            echo '<input type="hidden" name="listing_id" value="' . $row['listing_id'] . '">';
                            echo '<button type="submit" name="delete_field_btn"><i class="fas fa-trash-alt"></i> Delete Field</button>';
                            echo '</form>';

                            echo '<form action="edit_my_field.php" method="post">';
                            echo '<input type="hidden" name="listing_id" value="' . $row['listing_id'] . '">';
                            echo '<button type="submit" name="edit_field_btn"><i class="fas fa-edit"></i> Edit Field</button>';
                            echo '</form>';
                            echo '</div>'; // end button-container

                            echo '</div>'; // end field
                        }
                    } else {
                        echo '<p>No fields available.</p>';
                    }
                }
                $connect->close(); 
            ?>
        </div> <!-- end fields-list -->

    </div> <!-- end container -->

</body>
</html>
