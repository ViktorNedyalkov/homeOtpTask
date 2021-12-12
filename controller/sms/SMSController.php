<?php

class SMSController
{
    public function sendSMS(string $phoneNumber, string $smsCode)
    {

        $smsRepository = new \model\repository\SMSRepository();
        $smsRepository->sendSMS($phoneNumber, $smsCode);
    }
}