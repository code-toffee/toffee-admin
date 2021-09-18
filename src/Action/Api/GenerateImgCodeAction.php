<?php
declare(strict_types=1);

namespace App\Action\Api;

use App\Entity\Cache\ImgCaptchaCache;
use App\Utils\Captcha\CaptchaUtils;
use App\Utils\RedisUtils;

class GenerateImgCodeAction
{
    private RedisUtils $redisUtils;

    /**
     * GenerateImgCodeAction constructor.
     * @param RedisUtils $redisUtils
     */
    public function __construct(RedisUtils $redisUtils)
    {
        $this->redisUtils = $redisUtils;
    }

    public function run(): CaptchaUtils
    {
        $captcha = new CaptchaUtils();

        $obj = $captcha->generate();

        $captchaCache = new ImgCaptchaCache($obj->getKey());
        $captchaCache->code = $obj->getCode();

        $this->redisUtils->setObject($captchaCache, 5 * 60);

        return $obj;
    }
}
