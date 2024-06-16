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
    <link rel="stylesheet" href="../css/add_field.css">
    <title>Add Field</title>

</head>
<body>

    <div class="menu">
        <p><a href="index.php"> <i class='bx bx-arrow-back'></i> Back </a></p>
    </div>

    <div class="container">
        <h1> Add Field</h1>
        <form action="../php/server_add_field.php" method="post" enctype="multipart/form-data">

            
            <input type="text" placeholder="Title" name="title" required> 
            <textarea placeholder="Description" name="description" ></textarea>
            <input type="text" placeholder="Price" name="price" required> 
            <input type="text" placeholder="Adress" name="location" required> 

            <select name="city" required>
                <option value="" disabled selected>Select city</option>
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
                <option value="Vilnius">Vilnius rajonas</option>
                <option value="Kaunas">Kauno rajonas</option>
                <option value="Klaipėda">Klaipėdos rajonas</option>
            </select>

            <select name="category" required>
                <option value="" disabled selected>Select category</option>
                    <?php
                        //Dla wyswietlenia categorii
                        $query = "SELECT category_id, name FROM Categories";
                        $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                            }
                        }
                        mysqli_close($connect);
                    ?>
            </select>
            
            <input type="file" placeholder="Choose photo" name="images[]" multiple required> 
            <button type="submit" name="upload_field_btn"> <i class="fas fa-save"></i> Upload </button>
        </form>
    </div>


    <?php
        if(isset($_SESSION['add_field_message'])){
            echo '<p class="message">' . $_SESSION['add_field_message'] . '</p>';
            unset($_SESSION['add_field_message']);
        }
    ?>

</body>
</html>
