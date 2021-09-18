<?php
declare(strict_types=1);

namespace App\Utils\TokenUtils;

use App\Utils\DES;
use Exception;
use JMS\Serializer\SerializerBuilder;

class TokenUtils
{
    private string $secret;

    private DES $encryptor;

    /**
     * TokenUtils constructor.
     */
    public function __construct()
    {
        $this->secret = $_ENV['APP_SECRET'];
        $this->encryptor = new DES($this->secret, 'DES-ECB', DES::OUTPUT_BASE64);
    }

    /**
     * 生成 Token
     * @param string $uid
     * @param string $ttl
     * @param string $platform
     * @return string
     */
    public function generateToken(string $uid, string $ttl = "+1 day", string $platform = "web"): string
    {
        $ser = SerializerBuilder::create()->build();
        $token = new TokenDto();
        $token->id = $uid;
        $token->platform = $platform;
        $token->loginDate = date('Y-m-d H:i:s', time());
        $token->expired = date('Y-m-d H:i:s', strtotime($ttl));
        return $this->encryptor->encrypt($ser->serialize($token, 'json'));
    }

    /**
     * 验证 Token
     * @param string $token
     * @return TokenDto|false
     */
    public function validateToken(string $token)
    {
        try {
            $ser = SerializerBuilder::create()->build();
            $data = $this->encryptor->decrypt($token);
            /**
             * @var TokenDto $obj
             */
            $obj = $ser->deserialize($data, TokenDto::class, 'json');
            if (strtotime($obj->expired)<time()) {
                return false;
            }
            return $obj;
        } catch (Exception $e) {
            return false;
        }
    }
}
