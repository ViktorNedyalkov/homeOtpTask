<?php
// Start Session
if (session_status() == PHP_SESSION_NONE) {

    session_start();
    
} else if (isset($_SESSION['userId'])) { // Check if user have session (if user is logged)
    if ($_SESSION['userValidated'] == true) {
        header('Location: ../../view/main/index.php');
        die();
    }

} else {
    header('Location: ../../view/user/login.php');
}

//header('Location: ../../view/user/login.php');
//die();