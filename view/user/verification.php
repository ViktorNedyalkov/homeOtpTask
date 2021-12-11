<?php
//Check for Session
require_once "../../utility/session_main.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Validation</title>
</head>
<body>

<div class="login-page">

    <div class="form">
        <form class="verification-form" action="../../handlers/verification_handler.php" method="post">
            <input type="text" name="verificationCode" placeholder="Enter code" required/>

            <input id="verification" type="submit" value="VERIFICATION">

            <?php if(isset($_GET['wrongCode'])){ echo "<p id=\"wrongCode\">Wrong Code!</p>"; };?>
            <?php if(isset($_GET['tooManyAttempts'])){ echo "<p id=\"tooManyAttempts\">Too many attempts, try again in 1 minute!</p>"; };?>
        </form>
    </div>
    <div class="resendCode">
        <form action="../../handlers/verification_handler.php" method="post">
            <input name='resendVerification' type="submit" value="Resend code" />
        </form>


        <?php if(isset($_GET['newCode'])){ echo "<p id=\"newCode\">Code Resent!</p>"; };?>
    </div>
</div>

</body>
</html>