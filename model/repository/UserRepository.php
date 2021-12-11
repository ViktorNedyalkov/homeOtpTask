<?php

namespace model\repository;

use model\User;
use model\repository\AbstractRepository;

use PDOException;
class UserRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Connection::getInstance()->getConnection());
    }


    public function registerUser(User $user, string $verificationCode): User
    {
        $query = '
            INSERT INTO 
                users (email, password, validated, phone) 
            VALUES (:email, :password, 0, :phone)';

        $bindParams = [
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'phone' => $user->getPhone()
        ];
        try {
            $this->beginTransaction();

            $userId = $this->executeInsert($query, $bindParams);

            $user->setId($userId);

            // make insertion of verification code
            $verificationRepository = new VerificationRepository();

            $verificationRepository->insertNewVerificationCode($user, $verificationCode);
            $this->commitTransaction();

            return $user;


        } catch (PDOException $e) {
            $this->rollbackTransaction();
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    }

    public function activateUser(User $user)
    {

        $query = 'UPDATE users SET validated=:validated WHERE id=:userId';

        $bindParams = [
            'userId' => $user->getId(),
            'validated' => 1
        ];
        try {
            $this->beginTransaction();

            $this->executeUpdate($query, $bindParams);

            $verificationRepository = new VerificationRepository();
            $verificationRepository->deactivateAllCodesForUser($user);

            $this->commitTransaction();
        } catch (PDOException $e) {
            $this->rollbackTransaction();
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }

    }

    public function getUser(int $userId)
    {
        $query = 'SELECT id, email, password, validated, phone FROM users WHERE id=:userId';

        $bindParams = [
            'userId' => $userId
        ];

        return $this->fetchRowAssoc($query, $bindParams);
    }


    public function checkLogin(string $email, string $password): ?array
    {

        $query = 'SELECT id, email, password, validated, phone FROM users WHERE email=:email AND password=:password';

        $bindParams = [
            'email' => $email,
            'password' => $password
        ];

        return $this->fetchRowAssoc($query, $bindParams);
    }

    public function checkUserExists(User $user): int
    {
        $query = 'SELECT id FROM users WHERE email=:email';

        $bindParams = [
            'email' => $user->getEmail()
        ];

        return $this->execute($query, $bindParams)->rowCount();

    }

    public function update(User $user): int
    {
        $query = 'UPDATE users SET email=:email, password=:password, phone=:phone, validated=:validated WHERE id=:id';

        $bindParams = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'validated' => $user->getValidated(),
            'password' => $user->getPassword(),
            'phone' => $user->getPhone()
        ];

        return $this->executeUpdate($query, $bindParams);
    }
}