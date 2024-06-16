<?php
session_start();
require_once '../php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites</title>
    <link rel="stylesheet" href="../css/my_favorite_fields.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<body>
    <div class="menu">
        <p><a href="index.php"> <i class="fas fa-arrow-left"></i> Back </a></p>
    </div>

    <div class="container">
        <h1>My Favorites</h1>

        <?php
        if (isset($_SESSION['userid'])) {
            $userid = $_SESSION['userid'];

            $sql = "SELECT l.listing_id, l.title, l.description, l.price, l.location, l.city, l.user_id, u.avatar, u.username, GROUP_CONCAT(i.image_url) AS images
                    FROM Listings l 
                    INNER JOIN Favorites f ON l.listing_id = f.listing_id
                    LEFT JOIN Users u ON l.user_id = u.user_id
                    LEFT JOIN Images i ON l.listing_id = i.listing_id 
                    WHERE f.user_id = ?
                    GROUP BY l.listing_id";

            $stmt = $connect->prepare($sql); // Przygotowuje zapytanie SQL
            $stmt->bind_param("i", $userid); // Powiązuje wartość user_id z placeholderem (f.user_id = ?) w zapytaniu SQL
            $stmt->execute(); // Wykonuje zapytanie SQL
            $result = $stmt->get_result(); //Wpisuje rezultat do zmiennej $result

            // Wyswietla ulubione ogloszenia
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //Informacja ogloszenia
                    echo '<div class="listing">';
                    echo '<h2>' . $row['title'] . '</h2>';
                    echo '<p>Description: ' . $row['description'] . '</p>';
                    echo '<p>Price: $' . $row['price'] . '</p>';
                    echo '<p>Location: ' . $row['location'] . '</p>';
                    echo '<p>City: ' . $row['city'] . '</p>';

                    // Wyswietl obrazki
                    if ($row['images'] != null) {
                        $images = explode(',', $row['images']);
                        foreach ($images as $image) {
                            echo '<img src="../field_images/' . $image . '" alt="Listing Image">';
                        }
                    }

                    // Przycisk delete from favorites
                    echo '<form class="delete-form" action="../php/server_delete_favorites.php" method="post">';
                    echo '<input type="hidden" name="listing_id" value="' . $row['listing_id'] . '">';
                    echo '<button type="submit" name="delete_favorite_btn"><i class="far fa-trash-alt"></i> Delete from favorites</button>';
                    echo '</form>';

                    echo '</div>'; // <!-- end listing -->
                }
            } else {
                echo '<p>No favorites found.</p>';
            }

            $stmt->close();
        } else {
            echo '<p>Please log in to view your favorites.</p>';
        }

        $connect->close();
        ?>

    </div> <!-- end container -->

</body>
</html>
