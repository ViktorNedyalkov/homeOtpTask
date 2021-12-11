<?php
// Start Session
if (session_status() == PHP_SESSION_NONE) {

    session_start();
}
//var_dump($_SESSION);die();
//session_destroy();
//var_dump(session_status());die();
// Check if user have session (if user is logged)
if (isset($_SESSION['userId'])) {
    if ($_SESSION['userValidated'] == true) {
        header('Location: ../../view/main/index.php');
        die();
    }

} else {
    header('Location: ../../view/user/login.php');
}

//header('Location: ../../view/user/login.php');
//die();