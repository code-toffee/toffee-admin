<?php
declare(strict_types=1);

namespace App\Service\Sms\MeiLianHuTong;

use App\Contract\SmsInterface;

class SmsInterfaceImpl implements SmsInterface
{
    private SmsService $smsService;
    /**
     * SmsInterfaceImpl constructor.
     * @param string $apiUrl
     * @param string $user
     * @param string $pass
     * @param string $apiKey
     */
    public function __construct(string $apiUrl, string $user, string $pass, string $apiKey)
    {
        $this->smsService = SmsService::build($apiUrl, $user, $pass, $apiKey);
    }

    /**
     * @param $code
     * @param $expir
     * @param $userPhone
     * @return bool
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    function sendSmsVerifiCode($code, $expir, $userPhone): bool
    {
        $connect = "【XXX】您的验证码是%s。验证码有效期为%s分钟，请尽快使用。";
        $connect = sprintf($connect, $code, $expir);
        return $this->smsService->send($userPhone, $connect);
    }
}
