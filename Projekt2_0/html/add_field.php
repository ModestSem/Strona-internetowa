<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add_field.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Add Field</title>
</head>
<body>
    <h1> Add Field</h1>

    <form id="field_form" action="../php/server_add_field.php" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Enter header" name="header" required> 
        <input type="text" placeholder="Enter price" name="price" required> 
        <input type="text" placeholder="Enter phone number" name="phonenumber" required> 
        <select name="city" required>
            <option value="" disabled selected>Select city</option>
            <option value="Vilnius">Vilnius</option>
            <option value="Kaunas">Kaunas</option>
            <option value="Klaipeda">Klaipeda</option>
        </select>
        <input type="file" placeholder="Choose photo" name="image" required> <br>

        <button type="submit" name="upload">Upload <i class="fas fa-upload"></i></button>
        <button id="back_to_main"><i class="fas fa-arrow-left"></i> back</button>
    </form>

    <script>
        document.getElementById("back_to_main").onclick = function() {
            window.location.href = "index.php";
        };

        document.getElementById("field_form").onsubmit = function() {
            alert("Field sent for admin review!");
        };
    </script>    
</body>
</html>
