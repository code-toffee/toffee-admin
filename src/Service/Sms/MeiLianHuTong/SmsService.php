<?php
declare(strict_types=1);

namespace App\Service\Sms\MeiLianHuTong;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SmsService
{
    private string $apiUrl;

    private string $user;//短信平台帐号

    private string $pass;//短信平台密码

    private string $apiKey;//短信平台密码

    /**
     * SmsService constructor.
     * @param string $apiUrl
     * @param string $user
     * @param string $pass
     * @param string $apiKey
     */
    public function __construct(string $apiUrl, string $user, string $pass, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->user = $user;
        $this->pass = $pass;
        $this->apiKey = $apiKey;
    }

    public static function build($apiUrl, $user, $pass, $apiKey): SmsService
    {
        return new static($apiUrl, $user, $pass, $apiKey);
    }

    /**
     * 发送短信
     * @param $phone
     * @param $connect
     * @return bool
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     * @auther yuhz 2020/6/22 13:00
     */
    public function send($phone, $connect): bool
    {
        $method = '/send/index.php';
        $url = $this->apiUrl . $method;
        $option = [
            'query' => [
                'username'     => $this->user,
                'password_md5' => md5($this->pass),
                'apikey'       => $this->apiKey,
                'mobile'       => $phone,
                'content'      => $connect,
                'encode'       => 'utf-8'
            ]
        ];

        $client = HttpClient::create();
        $request = $client->request('GET', $url, $option);
        $result = $request->getContent();

        if (strstr($result, 'error:')) {
            throw new Exception('短信平台接口错误');
        }

        return true;
    }
}
