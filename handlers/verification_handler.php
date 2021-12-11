<?php

require_once '../utility/autoloader.php';
require_once '../utility/session_main.php';
require_once '../utility/error_handler.php';

if (!empty($_POST['verificationCode'])) {

    $verificationController = new controller\verification\VerificationController();

    $verificationController->verifyUser($_POST['verificationCode']);

}

if (!empty($_POST['resendVerification'])) {

    $verificationController = new controller\verification\VerificationController();

    $verificationController->createNewVerification();

}