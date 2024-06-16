<?php
    session_start();
    require_once 'connect.php';

    if (isset($_POST['delete_favorite_btn']) && isset($_SESSION['userid']) && isset($_POST['listing_id'])) {
        $userid = $_SESSION['userid'];
        $listing_id = $_POST['listing_id'];

        $sql = "DELETE FROM Favorites WHERE user_id = ? AND listing_id = ?";
        $stmt = $connect->prepare($sql); // Przygotowuje zapytanie SQL
        $stmt->bind_param("ii", $userid, $listing_id); // Powiązuje wartość user_id i listing_id z placeholderami (user_id = ?, listing_id = ?) w zapytaniu SQL
        $stmt->execute();    // Wykonuje zapytanie SQL
        $stmt->close(); 

        header('Location: ../html/my_favorite_fields.php');
        exit;
    } else {

        header('Location: ../html/index.php');
        exit;
    }
?>
