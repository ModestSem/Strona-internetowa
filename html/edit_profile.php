<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/edit_profile.css">
    <title>Edit Profile</title>
</head>
<body>

<div class="menu">
    <p><a href="index.php"> <i class='bx bx-arrow-back'></i> Back </a></p>
</div>

<h1>Edit profile</h1>

<form action="../php/server_edit_profile.php" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Username" name="username" required>
    <input type="text" placeholder="Phone number" name="phoneNumber" required>
    <input type="password" placeholder="New Password" name="pass" required>
    <input type="password" placeholder="Confirm New Password" name="pass2" required>
    <input type="file" name="avatar" required>
    <button type="submit" name="update_profile_btn"> <i class="fas fa-save"></i> Update </button>
</form>

<?php
    if(isset($_SESSION['editprofile_message'])){
        echo '<p>' . $_SESSION['editprofile_message'] . '</p>';
        unset($_SESSION['editprofile_message']);
    }
?>

</body>
</html>
