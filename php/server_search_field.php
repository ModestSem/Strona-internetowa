<?php
    session_start();
    require_once '../php/connect.php';

if (isset($_POST['city'])) {
    $city = $_POST['city'];
    $sql = "SELECT l.listing_id, l.title, l.description, l.price, l.location, l.city, l.user_id, u.avatar, u.username, GROUP_CONCAT(i.image_url) AS images
            FROM Listings l 
            LEFT JOIN Users u ON l.user_id = u.user_id
            LEFT JOIN Images i ON l.listing_id = i.listing_id 
            WHERE l.approved = 1";

    if ($city !== 'All') {
        $sql .= " AND l.city = ?";
    }

    $sql .= " GROUP BY l.listing_id";
    $stmt = $connect->prepare($sql);

    if ($city !== 'All') {
        $stmt->bind_param("s", $city);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Wyświetlenie avataru użytkownika i nazwy użytkownika
            echo '<div class="user-info">';
            echo '<img src="../avatars/' . $row["avatar"] . '" alt="User Avatar">';
            echo '<p>' . $row["username"] . '</p>';
            echo '</div>';

            // Wyświetlenie informacji ogłoszenia
            echo "<h2>" . $row['title'] . "</h2>";

            // Wyświetlenie obrazków, jeśli są dostępne
            if ($row['images'] != null) {
                $images = explode(',', $row['images']);
                foreach ($images as $image) {
                    echo '<img src="../field_images/' . $image . '" alt="Listing Image">';
                }
            }

            // Wyświetlenie informacji ogłoszenia
            echo "<p>Description: " . $row['description'] . "</p>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "<p>Location: " . $row['location'] . "</p>";
            echo "<p>City: " . $row['city'] . "</p>";

            // Formularz do dodawania do ulubionych
            echo '<form action="../php/server_add_to_favourites.php" method="post">';
            echo '<input type="hidden" name="listing_id" value="' . $row['listing_id'] . '">';
            echo '<button type="submit" name="add_to_favourites_btn">Add to Favourite</button>';
            echo '</form>';

            echo "<hr>";
        }
    } else {
        echo "Brak dostępnych ogłoszeń.";
    }

    $stmt->close();
}
$connect->close();
?>
