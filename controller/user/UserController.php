<?php
namespace controller\user;

use model\repository\UserRepository;
use model\User;

class UserController
{
    public function registerUser($email, $password, $password2, $mobilePhone)
    {
        $mobilePhone = preg_replace('/[^0-9.]+/', '', $mobilePhone);

        if(strlen($mobilePhone) === 10 && strpos($mobilePhone, "0") === 0) {
            // check if the phone is given in the format of 087
            $mobilePhone = substr_replace($mobilePhone, '359', 0, 1);
        } else if (strlen($mobilePhone) === 12 && strpos($mobilePhone, "359") === 0 ) {
            // check if the phone is given in the format of +359
        } else {
            //Locate to error page Wrong Mobile Number
            header("Location: ../../view/user/register.php?errorMN");
            die();
        }

        if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 3 && strlen($email) < 254)) {
            //Locate to error Register Page
            header("Location: ../../view/user/register.php?errorEMAIL");
            die();
        }


        if (!(strlen($password) >= 4 && strlen($password) < 20 && strlen($password2) >= 4 && strlen($password2) < 20)) {
            //Locate to error page Wrong Password length
            header("Location: ../../view/user/register.php?errorPassSyntax");
            die();
        }

        if (!($password == $password2)) {
            //Locate to error page Wrong Password match
            header("Location: ../../view/user/register.php?errorPassMatch");
            die();
        }
        try {

            $userRepository = new UserRepository();
            $user = new User(htmlentities($email), htmlentities($mobilePhone), sha1($password), null, false);

            //Check if user exists
            if ($userRepository->checkUserExists($user)) {

                //Locate to error Register Page
                header("Location: ../../view/user/register.php?errorEmail");
            } else {
                $verificationCode = sprintf("%06d", mt_rand(1, 999999));
                $user = $userRepository->registerUser($user, $verificationCode);

                //create a verification code
                //save it in the db

                $_SESSION['userId'] = $user->getId();
                $_SESSION['userValidated'] = $user->getValidated();

                header("Location: ../../view/user/verification.php");

            }
            die();

        } catch (\Exception $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    }

    public function loginUser(string $email, string $password)
    {
        //validate email and password

        $password = sha1($password);

        $userRepository = new UserRepository();

        $userData = $userRepository->checkLogin($email, $password);

        if (empty($userData)) {
            header("Location: ../../view/user/login.php?notFound");
            die();
        }

        if ($userData['validated'] == false) {
            // we are going to prompt the user for verification

            $user = new User(
                $userData['email'],
                $userData['phone'],
                $userData['password'],
                $userData['id'],
                $userData['validated']
            );


            $_SESSION['userId'] = $user->getId();
            $_SESSION['userValidated'] = $user->getValidated();

            header("Location: ../../view/user/verification.php");
            die();
        }

        header("Location: ../view/main/index.php");
        die();
    }
}