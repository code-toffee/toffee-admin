<?php

namespace App\Contract;

interface SmsInterface
{
    function sendSmsVerifiCode($code, $expir, $userPhone);
}
