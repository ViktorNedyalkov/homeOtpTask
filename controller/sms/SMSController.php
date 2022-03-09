<?php

namespace controller\sms;

use controller\AbstractController;

class SMSController extends AbstractController
{
    public function sendSMS(string $phoneNumber, string $smsCode)
    {
        $smsRepository = new \model\repository\SMSRepository();
        $smsRepository->sendSMS($phoneNumber, $smsCode);
    }
}