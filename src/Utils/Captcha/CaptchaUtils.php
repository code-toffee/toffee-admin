<?php
declare(strict_types=1);

namespace App\Utils\Captcha;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class CaptchaUtils
{
    private string $key;

    private string $code;

    private string $imgData;

    private int $length;

    /**
     * CaptchaUtils constructor.
     * @param int $length
     */
    public function __construct(int $length = 4)
    {
        $this->length = $length;
    }

    public function generate(): CaptchaUtils
    {
        $phraseBuilder = new PhraseBuilder($this->length);
        $captcha = new CaptchaBuilder(null, $phraseBuilder);
        $captcha->build();

        //转换大写
        $this->code = strtoupper($captcha->getPhrase());

        $this->imgData = $captcha->inline();

        //计算密钥
        $key = $this->code . microtime() . mt_rand() . mt_rand() . mt_rand();
        $md5 = md5($key);
        $this->key = hash_hmac('sha256', $key . $md5, '');

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getImgData(): string
    {
        return $this->imgData;
    }
}
