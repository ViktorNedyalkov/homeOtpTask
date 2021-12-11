<?php
namespace controller\verification;

use model\repository\UserRepository;
use model\repository\VerificationRepository;
use model\User;

class VerificationController
{
    public function verifyUser(string $verificationCode)
    {

        // check if user is in the session
//        var_dump($_SESSION);die();
        if (!isset($_SESSION['userId'])) {
            header("Location: ../../view/user/login.php");
            die();
        }
        $userId = $_SESSION['userId'];
        $userRepository = new UserRepository();
        $userData = $userRepository->getUser($userId);

        if (empty($userData)) {
            header("Location: ../../view/user/login.php");
            die();
        }

        $user = new User(
            $userData['email'],
            $userData['phone'],
            $userData['password'],
            $userData['id'],
            $userData['validated']
        );

        //get verification of user
        $validationRepository = new VerificationRepository();
        //check verification instances

        $attempts = $validationRepository->verificationAttemptsInLastMinute($user);

        if ($attempts['attempts'] >= 3) {
            header("Location: ../../view/user/verification.php?tooManyAttempts");
            die();
        }

        $validationRepository->logUserVerificationAttempt($user);

        //verification code is only numbers
        $verificationCode = preg_replace('/[^0-9.]+/', '', $verificationCode);

        $verificationCodeData = $validationRepository->getVerificationCode($user, $verificationCode);
        if (empty($verificationCodeData)) {
            header("Location: ../../view/user/verification.php?wrongCode");
            die();
        }

        $userRepository->activateUser($user);

        $_SESSION['userId'] = $user->getId();
        $_SESSION['userValidated'] = $user->getValidated();

        header('Location: ../../view/main/index.php');
        die();
    }

    public function createNewVerification()
    {
        //get user id from session
        if (!isset($_SESSION['userId'])) {
            header("Location: ../../view/user/login.php");
            die();
        }
        $userId = $_SESSION['userId'];
        $userRepository = new UserRepository();
        $userData = $userRepository->getUser($userId);

        if (empty($userData)) {
            header("Location: ../../view/user/login.php");
            die();
        }
        $user = new User(
            $userData['email'],
            $userData['phone'],
            $userData['password'],
            $userData['id'],
            $userData['validated']
        );

        //verify that the user is not trying to recreate a code before the 1 minute cooldown has passed

        $verificationRepository = new VerificationRepository();

        $numberOfAttempts = $verificationRepository->getUserCodeResendAttempts($user);

        if (empty($numberOfAttempts) || $numberOfAttempts['attempts'] >= 1) {
            header("Location: ../../view/user/verification.php?tooManyAttempts");
            die();
        }

        $verificationRepository->insertNewVerificationCode($user, $this->generateVerificationCode());

        header("Location: ../../view/user/verification.php?newCode");
        die();
    }

    private function generateVerificationCode(): string
    {
        return sprintf("%06d", mt_rand(1, 999999));
    }

}