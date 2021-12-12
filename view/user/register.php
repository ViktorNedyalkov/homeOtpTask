<?php
//Check for Session
//require_once "../../utility/session_main.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS for login/register/edit form -->
    <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">

    <title>Register</title>
</head>
<body>

<div class="login-page">

    <div class="form">
        <form class="login-form" action="../../handlers/register_handler.php" method="post">

            <p class="wrongInput" <?= (!isset($_GET['errorField'])) ?:"style='display: block;'"?>>
                All fields are required!</p>
            <input type="email" name="email" placeholder="Your Email"  required/>
            <p class="wrongInput" <?= (!isset($_GET['errorEmail'])) ?:"style='display: block;'"?>>
                Email already exists!</p>

            <input type="password" name="password" placeholder="Your Password"
                   pattern=".{4,20}" required title="Password 4 to 20 characters"/>
            <p class="wrongInput" <?= (!isset($_GET['errorPassSyntax'])) ?:"style='display: block;'"?>>
                Passwords must be between 4 and 12 symbols!</p>
            <p class="wrongInput" <?= (!isset($_GET['errorPassMatch'])) ?:"style='display: block;'"?>>
                Passwords doesn't match!</p>

            <input type="password" name="password2" placeholder="Repeat Password"
                   pattern=".{4,20}" required title="Password 4 to 20 characters"/>

            <input type="tel" name="mobilePhone" placeholder="Mobile Number"
                   pattern="[0-9]{10}" required title="Number must be 10 digits"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorMN'])) ?:"style='display: block;'"?>>
                Mobile Number should be 10 digits!</p>

            <input id="login" type="submit" value="REGISTER">
            <p class="message">Already a user? <a href="login.php">&nbspLog In</a></p>
        </form>
    </div>
</div>

</body>
</html>