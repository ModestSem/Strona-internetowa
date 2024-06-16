<?php

    session_start();
    require_once 'connect.php';

    if (isset($_POST['upload_field_btn'])) {  // Sprawdzenie, czy formularz został wysłany (przycisk "Upload" został kliknięty)

        // Pobranie danych z formularza
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $location = $_POST['location'];
        $city = $_POST['city'];
        $category_id = $_POST['category'];
        $userid = $_SESSION['userid']; // Pobranie identyfikatora użytkownika z sesji
        
        if (isset($_FILES['images'])) { // Sprawdzenie, czy zostały przesłane pliki
            $errors = []; // Tablica na błędy
            $uploadedFiles = []; // Tablica na nazwy przesłanych plików
            $allowed_ext = array( // Lista dozwolonych rozszerzeń plików
                'png',
                'bmp',
                'jpg',
                'jpeg',
                'JPG',
                'PNG',
                'JPEG'
            ); 

            $files = $_FILES['images']; // Tablica z przesłanymi plikami
            $fileCount = count($files['name']); // Liczba przesłanych plików 

            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $files['name'][$i];
                $fileTmpName = $files['tmp_name'][$i];
                $fileSize = $files['size'][$i];
                $fileError = $files['error'][$i];

                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Rozszerzenie pliku

                if (in_array($fileExt, $allowed_ext)) { // Sprawdzenie, czy rozszerzenie pliku jest dozwolone
                    if ($fileSize < 40097152) { // Sprawdzenie, czy rozmiar pliku jest mniejszy niż 40 MB
                        $fileNewName = uniqid('', true) . "." . $fileExt; // Generowanie unikalnej nazwy pliku
                        $fileDestination = '../field_images/' . $fileNewName; // Ścieżka docelowa zapisu pliku

                        if (move_uploaded_file($fileTmpName, $fileDestination)) { // Przeniesienie pliku do docelowej lokalizacji
                            $uploadedFiles[] = $fileNewName; // Dodanie nazwy pliku do tablicy przesłanych plików
                        } else {
                            $errors[] = "Error uploading $fileName.";
                            $_SESSION['add_field_message'] = 'Error uploading!!';
                            header('Location: ../html/add_field.php');
                            exit;
                        }
                    } else {
                        $errors[] = "File $fileName is too large!";
                        $_SESSION['add_field_message'] = 'File is to large!';
                        header('Location: ../html/add_field.php');
                        exit;
                    }
                } else {
                    $errors[] = "Unsupported file format for $fileName.";
                    $_SESSION['add_field_message'] = 'Unsupported file format!';
                    header('Location: ../html/add_field.php');
                    exit;
                }
            }

            if (empty($errors)) { // Sprawdzenie, czy nie wystąpiły żadne błędy podczas przesyłania plików z tablicy errors
                $uploadedFilesStr = implode(',', $uploadedFiles); // Konwersja tablicy nazw plików na ciąg znaków
                $query = "INSERT INTO Listings (title, description, price, category_id, user_id, location, city, approved) VALUES ('$title', '$description', '$price', '$category_id' ,'$userid', '$location', '$city', '0')";

                if (mysqli_query($connect, $query)) {
                    $listing_id = mysqli_insert_id($connect); // Pobranie ID ostatnio wstawionego rekordu

                    // Zapis nazw plików do tabeli Images
                    foreach ($uploadedFiles as $image) {
                        $insert_image_query = "INSERT INTO Images (listing_id, image_url) VALUES ('$listing_id', '$image')";
                        mysqli_query($connect, $insert_image_query);
                    }
                    
                    $_SESSION['add_field_message'] = 'Field sent to admin to check!!';
                        header('Location: ../html/add_field.php');
                        exit;

                } else {
                    echo "Error: " . mysqli_error($connect);
                    exit;
                }
            } else {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            }
        } else {
            echo "No files were uploaded.";
        }

        mysqli_close($connect);
    }
?>
