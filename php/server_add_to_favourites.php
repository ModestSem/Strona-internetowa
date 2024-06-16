<?php
    session_start();
    require_once 'connect.php';

    if (isset($_POST['add_to_favourites_btn'])) {
        if (isset($_SESSION['userid']) && isset($_POST['listing_id'])) {
            $userid = $_SESSION['userid'];
            $listing_id = $_POST['listing_id'];

            // Sprawdzenie, czy ogłoszenie nie jest już w ulubionych użytkownika
            $check_sql = "SELECT * FROM Favorites WHERE user_id = ? AND listing_id = ?";
            $check_stmt = $connect->prepare($check_sql); // Przygotowuje zapytanie SQL
            $check_stmt->bind_param("ii", $userid, $listing_id); // Powiązuje wartość user_id i listing_id z placeholderami (user_id = ?, listing_id = ?) w zapytaniu SQL
            $check_stmt->execute(); // Wykonuje zapytanie SQL
            $check_result = $check_stmt->get_result(); // Pobiera wyniki wykonania zapytania SQL i przypisuje do zmiennej $result

            if ($check_result->num_rows == 0) {
                // Jeśli ogłoszenie nie jest jeszcze w ulubionych, dodaj do Favorites
                $insert_sql = "INSERT INTO Favorites (user_id, listing_id) VALUES (?, ?)";
                $insert_stmt = $connect->prepare($insert_sql); // Przygotowuje zapytanie SQL ($insert_sql)
                $insert_stmt->bind_param("ii", $userid, $listing_id); // Powiązuje wartość user_id i listing_id z placeholderami (user_id = ?, listing_id = ?) w zapytaniu SQL
                $insert_stmt->execute(); // Wykonuje zapytanie SQL
                $insert_stmt->close();
            }
            $check_stmt->close();
        }
    }
    header('Location: ../html/index.php');
    exit;
?>
