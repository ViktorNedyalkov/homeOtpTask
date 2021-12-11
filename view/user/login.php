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

    <title>Login</title>
</head>
<body>

<div class="login-page">
    <div class="form">
        <form class="login-form" action="../../handlers/login_handler.php" method="post">
            <input type="email" name="email" placeholder="Enter Your Email" required/>
            <input type="password" name="password" placeholder="Enter Your Password"
                   pattern=".{4,20}" required title="Password 4 to 20 characters"/>

            <input id="login" type="submit" value="LOGIN">

            <?php if(isset($_GET['notFound'])){ echo "<p id=\"wrongLogin\">User not found!</p>"; };?>

            <p class="message">Not registered? <a href="register.php">Create an account</a></p>

        </form>
    </div>
</div>

</body>
</html>