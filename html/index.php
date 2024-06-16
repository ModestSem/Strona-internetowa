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
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <title>Store</title>

    <script>
        $('#submitform').submit(function (event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../php/server_add_to_favourites.php",
            data: $(this).serialize(),
            success: function (data) {
             
            }
            });
        });
    </script>
    
</head>
<body>
<div id="app-container">
    <?php
    if (isset($_SESSION['logedin'])) {

        $userid = $_SESSION['userid'];

        $sql = "SELECT avatar, username FROM Users WHERE user_id = ?";
        $stmt = $connect->prepare($sql); // Przygotowuje zapytanie SQL
        $stmt->bind_param("i", $userid); // Powiązuje wartość user_id z placeholderem (user_id = ?) w zapytaniu SQL
        $stmt->execute(); 
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div id="profile-container" class="section">
                    <div id="user-info">
                        <img id="avatar" src="../avatars/<?php echo $row["avatar"]; ?>" alt="User Avatar">
                        <p id="username"><?php echo $row["username"]; ?></p>
                    </div>

                    <div id="user-actions" class="section">
                        <p><a href="edit_profile.php"><i class='bx bxs-user'></i> Edit profile</a></p>
                        <p><a href="add_field.php"><i class='bx bx-plus'></i> Add field</a></p>
                        <p><a href="my_fields.php"><i class='bx bx-list-ul'></i> My fields</a></p>
                        <p><a href="my_favorite_fields.php"><i class='bx bxs-heart'></i> Favorites</a></p>
                    </div>

                    <form action="../php/server_logout.php" method="post" id="logout-form" class="section">
                        <button type="submit" name="logout_btn"> Log Out <i class="bx bx-log-out bx-flip-horizontal"></i></button>
                    </form>
                </div>
                <?php
            }
        }
    ?>
</div>

<form action="" method="post" id="filter-form" class="section">
    <select name="city">
        <option value="" disabled selected>Select city</option>
        <option value="All">All</option>
        <option value="Vilnius">Vilnius</option>
        <option value="Kaunas">Kaunas</option>
        <option value="Klaipėda">Klaipėda</option>
        <option value="Šiauliai">Šiauliai</option>
        <option value="Panevėžys">Panevėžys</option>
        <option value="Alytus">Alytus</option>
        <option value="Marijampolė">Marijampolė</option>
        <option value="Mažeikiai">Mažeikiai</option>
        <option value="Jonava">Jonava</option>
        <option value="Utena">Utena</option>
        <option value="Vilnius rajonas">Vilnius rajonas</option>
        <option value="Kauno rajonas">Kauno rajonas</option>
        <option value="Klaipėdos rajonas">Klaipėdos rajonas</option>
    </select>
    <button type="submit" name="search_btn">Search <i class="bx bx-search"></i></button>
</form>

<?php

$sql = "SELECT l.listing_id, l.title, l.description, l.price, l.location, l.city, l.user_id, u.avatar, u.username, u.phone_number, GROUP_CONCAT(i.image_url) AS images
            FROM Listings l 
            LEFT JOIN Users u ON l.user_id = u.user_id
            LEFT JOIN Images i ON l.listing_id = i.listing_id 
            WHERE l.approved = 1";

if (isset($_POST['search_btn']) && !empty($_POST['city']) && $_POST['city'] !== 'All') {
    $city = $_POST['city'];
    $sql .= " AND l.city = ?";
}

$sql .= " GROUP BY l.listing_id";

$stmt = $connect->prepare($sql);

if (isset($_POST['search_btn']) && !empty($_POST['city']) && $_POST['city'] !== 'All') {
    $stmt->bind_param("s", $city);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="listing-container section">
            <div class="listing-user-info">
                <img src="../avatars/<?php echo $row["avatar"]; ?>" alt="User Avatar">
                <p><?php echo $row["username"]; ?></p>
            </div>

            <h2><?php echo $row['title']; ?></h2>

            <?php
            if ($row['images'] != null) {
                $images = explode(',', $row['images']);
                foreach ($images as $image) {
                    echo '<img src="../field_images/' . $image . '" alt="Listing Image" class="listing-image">';
                }
            }
            ?>

            <p>Description: <?php echo $row['description']; ?></p>
            <p>Price: $<?php echo $row['price']; ?></p>
            <p>Location: <?php echo $row['location']; ?></p>
            <p>City: <?php echo $row['city']; ?></p>
            <p>Phone number: <?php echo $row['phone_number']; ?></p>

            <form id="submitform" action="../php/server_add_to_favourites.php" method="post" class="add-to-favourites-form">
                <input type="hidden" name="listing_id" value="<?php echo $row['listing_id']; ?>">
                <button type="submit" name="add_to_favourites_btn" class="favourite-btn"><i class='bx bxs-heart'></i> Add to favorites</button>
            </form>


        
        </div>
        <?php
    }
} else {
    echo "No fields available in this city.";
}

$stmt->close();
$connect->close();
} else {
    ?>
    <div id="profile-container" class="section">
        <div id="user-info">
            <img id="avatar" src="../avatars/guest.png" alt="User Avatar">
            <p id="username">Guest</p>
        </div>

        <div id="user-actions" class="section">
            <p><a href="login.php" class="login-btn">Log in <i class="bx bx-log-in"></i></a></p>
        </div>
    </div>

    <?php
    $sql = "SELECT l.title, GROUP_CONCAT(i.image_url) AS images
            FROM Listings l
            LEFT JOIN Images i ON l.listing_id = i.listing_id
            WHERE l.approved = 1 AND i.image_url IS NOT NULL
            GROUP BY l.listing_id";

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="listing-container section">
                <h2><?php echo $row['title']; ?></h2>
                <?php
                    if ($row['images'] != null) {
                        $images = explode(',', $row['images']);
                        echo '<img src="../field_images/' . $images[0] . '" alt="Listing Image" class="listing-image">';
                    }
                ?>
            </div>
            <?php
        }
    } else {
        echo "No fields available in this city.";
    }
    $connect->close();
}
?>
</body>
</html>
