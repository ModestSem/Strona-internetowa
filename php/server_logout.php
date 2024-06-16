<?php

    //zamykanie, usuniecie sesji
    if(isset($_POST['logout_btn'])){
        session_start();
        session_unset();
        session_destroy();
    
        header('Location: ../html/index.php');
    }
?>