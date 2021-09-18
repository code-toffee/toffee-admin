<?php
declare(strict_types=1);

namespace App\Task\Api;

use App\Entity\Cache\ImgCaptchaCache;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Utils\RedisUtils;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CheckImgCodeTask
{
    private RedisUtils $redisUtils;

    private ContainerBagInterface $params;

    /**
     * @param RedisUtils $redisUtils
     * @param ContainerBagInterface $params
     */
    public function __construct(RedisUtils $redisUtils, ContainerBagInterface $params)
    {
        $this->redisUtils = $redisUtils;
        $this->params = $params;
    }

    /**
     * @param string $key
     * @param string $code
     */
    public function run(string $key, string $code)
    {
        $debug = $this->params->get('kernel.debug');
        if ($debug) {
            return;
        }
        $code = strtoupper($code);
        //检查手机验证码是否正确
        $codeCache = $this->redisUtils->getObject(ImgCaptchaCache::class, $key);
        if (is_null($codeCache) || $codeCache->code !== $code) {
            throw new ValidatorInvalidParamsException('图形验证码错误');
        }
        $this->redisUtils->delObject($codeCache);
    }
}
