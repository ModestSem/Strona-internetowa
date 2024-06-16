<?php
session_start();
require_once '../php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit field</title>
    <link rel="stylesheet" href="../css/edit_my_field.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
    <div class="menu">
        <p><a href="my_fields.php"> <i class="fas fa-arrow-left"></i> Back</a></p>
    </div>

    <div class="container">
        <h1>Edit Field</h1>

        <?php
        if(isset($_POST['edit_field_btn'])) {
            if(isset($_POST['listing_id']) && !empty($_POST['listing_id'])) {
                $listing_id = $_POST['listing_id'];

                $sql = "SELECT * FROM Listings WHERE listing_id = ?";
                $stmt = $connect->prepare($sql); // Przygotowuje zapytanie SQL
                $stmt->bind_param("i", $listing_id); // Powiązuje wartość listing_id z placeholderem(?) w zapytaniu SQL
                $stmt->execute(); // Wykonuje zapytanie SQL
                $result = $stmt->get_result(); // Pobiera wyniki wykonania zapytania SQL i przypisuje do zmiennej $result

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $location = $row['location'];
                    $city = $row['city'];
        ?>

        <form class="edit-form" action="../php/server_update_field.php" method="post">
            <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
            
            <div class="form-group">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br><br>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"><?php echo $description; ?></textarea><br><br>
            </div>
            
            <div class="form-group">
                <label for="price">Price:</label><br>
                <input type="text" id="price" name="price" value="<?php echo $price; ?>"><br><br>
            </div>
            
            <div class="form-group">
                <label for="location">Location:</label><br>
                <input type="text" id="location" name="location" value="<?php echo $location; ?>"><br><br>
            </div>
            
            <div class="form-group">
                <label for="city">City:</label><br>
                <select name="city" id="city" required>
                    <option value="" disabled>Select city</option>
                    <option value="Vilnius" <?php if($city == 'Vilnius') echo 'selected'; ?>>Vilnius</option>
                    <option value="Kaunas" <?php if($city == 'Kaunas') echo 'selected'; ?>>Kaunas</option>
                    <option value="Klaipėda" <?php if($city == 'Klaipėda') echo 'selected'; ?>>Klaipėda</option>
                    <option value="Šiauliai" <?php if($city == 'Šiauliai') echo 'selected'; ?>>Šiauliai</option>
                    <option value="Panevėžys" <?php if($city == 'Panevėžys') echo 'selected'; ?>>Panevėžys</option>
                    <option value="Alytus" <?php if($city == 'Alytus') echo 'selected'; ?>>Alytus</option>
                    <option value="Marijampolė" <?php if($city == 'Marijampolė') echo 'selected'; ?>>Marijampolė</option>
                    <option value="Mažeikiai" <?php if($city == 'Mažeikiai') echo 'selected'; ?>>Mažeikiai</option>
                    <option value="Jonava" <?php if($city == 'Jonava') echo 'selected'; ?>>Jonava</option>
                    <option value="Utena" <?php if($city == 'Utena') echo 'selected'; ?>>Utena</option>
                    <option value="Vilnius rajonas" <?php if($city == 'Vilnius rajonas') echo 'selected'; ?>>Vilnius rajonas</option>
                    <option value="Kauno rajonas" <?php if($city == 'Kauno rajonas') echo 'selected'; ?>>Kauno rajonas</option>
                    <option value="Klaipėdos rajonas" <?php if($city == 'Klaipėdos rajonas') echo 'selected'; ?>>Klaipėdos rajonas</option>
                </select><br><br>
            </div>
            
            <button type="submit" name="update_field_btn"><i class="fas fa-save"></i> Update Listing</button> 
        </form>

        <?php
                } else {
                    echo "Listing not found.";
                }

                $stmt->close();
            } else {
                echo "Error: No listing_id provided.";
            }
        } else {
            echo "Error: No edit action.";
        }

        $connect->close();
        ?>
    </div> <!-- end container -->

    <?php
        if(isset($_SESSION['update_field'])){
            echo '<p>' . $_SESSION['update_field'] . '</p>';
            unset($_SESSION['update_field']);         
        }
    ?>

</body>
</html>
