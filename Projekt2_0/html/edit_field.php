<?php
session_start();
require_once '../php/connect.php';

if (isset($_GET['field_id'])) {
    $field_id = $_GET['field_id'];
    
    $sql = "SELECT * FROM field WHERE id = $field_id";
    $result = $connect->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Field not found";
        exit;
    }
} else {
    echo "No field ID provided";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit_field.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Edit Field</title>
</head>
<body>


    <form action="../php/server_edit_field.php" method="post">
        <img class="field_image" id="field_image" src="../field_images/<?php echo $row['field_image']; ?>">
        <input type="hidden" name="field_id" value="<?php echo $row["id"]; ?>">
        <input type="text" name="header" value="<?php echo $row["header"]; ?>">
        <input type="text" name="price" value="<?php echo $row["price"]; ?>">
        <input type="text" name="phone_number" value="<?php echo $row["phone_number"]; ?>">

        <select name="city" required>
            <option value="" disabled <?php echo $row['city'] ? '' : 'selected'; ?>>Select city</option>
            <option value="Vilnius" <?php echo $row['city'] == 'Vilnius' ? 'selected' : ''; ?>>Vilnius</option>
            <option value="Kaunas" <?php echo $row['city'] == 'Kaunas' ? 'selected' : ''; ?>>Kaunas</option>
            <option value="Klaipeda" <?php echo $row['city'] == 'Klaipeda' ? 'selected' : ''; ?>>Klaipeda</option>
        </select>

        <button type="submit" name="update_btn">Update  <i class="fas fa-redo"></i></button>
        <button type="submit" name="back_btn"><i class="fas fa-arrow-left"></i>  Back</button>
    </form>


</body>
</html>
