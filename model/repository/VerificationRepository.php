<?php

namespace model\repository;

use model\User;
use PDO;

class VerificationRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::__construct(Connection::getInstance()->getConnection());
    }

    public function insertNewVerificationCode(User $user, string $verificationCode)
    {
        $query = '
            INSERT INTO 
                users_verification_codes (user_id, verification_code, creation_time, active) 
            VALUES (:userId, :verificationCode, now(), 1)';

        $bindParams = [
            'userId' => $user->getId(),
            'verificationCode' => $verificationCode
        ];

        try {
            if (! $this->inTransaction()) {
                $this->beginTransaction();

                $this->deactivateAllCodesForUser($user);

                $this->executeInsert($query, $bindParams);

                $this->commitTransaction();
            } else {

                // Done like this because this function gets called in other transactions during the registration
                $this->deactivateAllCodesForUser($user);

                $this->executeInsert($query, $bindParams);
            }


        } catch (\PDOException $e) {
            $this->rollbackTransaction();

            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    }


    public function getVerificationCode(User $user, string $verificationCode): ?array
    {
        $query = '
            SELECT 
                user_id AS userId, 
                verification_code AS verificationCode, 
                creation_time AS creationTime, 
                active 
            FROM 
                users_verification_codes 
            WHERE 
                user_id=:userId AND verification_code=:verificationCode AND active=1';

        $bindParams = [
            'userId' => $user->getId(),
            'verificationCode' => $verificationCode
        ];

        return $this->fetchRowAssoc($query, $bindParams);
    }

    /**
     * Checks if the user has requested a new code in less than a minute
     */
    public function verificationAttemptsInLastMinute(User $user): ?array
    {

        $query = 'SELECT COUNT(id) AS attempts FROM users_verification_log WHERE datetime > NOW() - INTERVAL 1 MINUTE AND user_id=:userId';
        $bindParams = [
            'userId' => $user->getId()
        ];
        return $this->fetchRowAssoc($query, $bindParams);
    }

    /**
     * Gets the number of attempts the user has tried to resend a verification code in the lsat minute
     * @param User $user
     * @return array|null
     */
    public function getUserCodeResendAttempts(User $user): ?array
    {
        $query = 'SELECT COUNT(id) AS attempts FROM users_verification_codes WHERE creation_time > NOW() - INTERVAL 1 MINUTE AND user_id=:userId';
        $bindParams = [
            'userId' => $user->getId()
        ];

        return $this->fetchRowAssoc($query, $bindParams);
    }

    public function logUserVerificationAttempt(User $user): int
    {
        $query = 'INSERT INTO users_verification_log (user_id, datetime) VALUES (:userId, now())';
        $bindParams = [
            'userId' => $user->getId()
        ];

        return $this->executeInsert($query, $bindParams);
    }
    public function deactivateAllCodesForUser(User $user): int
    {
        $query = 'UPDATE users_verification_codes SET active=0 WHERE user_id=:userId';
        $bindParams = [
            'userId' => $user->getId()
        ];

        return $this->executeUpdate($query, $bindParams);
    }
}