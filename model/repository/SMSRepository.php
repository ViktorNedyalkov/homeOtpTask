<?php

namespace model\repository;

class SMSRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::__construct(Connection::getInstance()->getConnection());
    }

    /**
     * Mock function, rather than sending the sms we will save a "save sms" entry in the db
     */
    public function sendSMS(string $phoneNumber, string $smsCode)
    {
        $query = 'INSERT INTO sms (phone_number, sms_code, sent_date) VALUES (:phoneNumber, :smsCode, now())';

        $bindParams = [
            'phoneNumber' => $phoneNumber,
            'smsCode' => $smsCode
        ];

        return $this->executeInsert($query, $bindParams);
    }
}