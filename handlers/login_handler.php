<?php
require_once '../utility/autoloader.php';
require_once '../utility/session_main.php';
require_once __DIR__ . '/../utility/error_handler.php';
//Check if user is logged


if (!empty($_POST['email']) &&
    !empty($_POST['password']))
{

    $userController = new controller\user\UserController();

    $userController->loginUser($_POST['email'], $_POST['password']);

}