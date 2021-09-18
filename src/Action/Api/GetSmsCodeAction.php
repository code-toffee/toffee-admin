<?php
declare(strict_types=1);

namespace App\Action\Api;

use App\Contract\SmsInterface;
use App\Dto\Api\Request\GetSmsDto;
use App\Entity\Cache\SmsCodeCache;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Task\Api\CheckImgCodeTask;
use App\Utils\RedisUtils;
use ReflectionException;

class GetSmsCodeAction
{
    private RedisUtils $redisUtils;

    private SmsInterface $smsService;

    private CheckImgCodeTask $checkImgCodeTask;

    /**
     * GetSmsCodeAction constructor.
     * @param RedisUtils $redisUtils
     * @param SmsInterface $smsService
     * @param CheckImgCodeTask $checkImgCodeTask
     */
    public function __construct(RedisUtils $redisUtils, SmsInterface $smsService, CheckImgCodeTask $checkImgCodeTask)
    {
        $this->redisUtils = $redisUtils;
        $this->smsService = $smsService;
        $this->checkImgCodeTask = $checkImgCodeTask;
    }

    /**
     * @param GetSmsDto $smsDto
     * @throws ReflectionException
     */
    public function run(GetSmsDto $smsDto)
    {
        //检查图形验证码是否正确
        $this->checkImgCodeTask->run($smsDto->key,$smsDto->code);

        $cache = $this->redisUtils->getObject(SmsCodeCache::class, $smsDto->phone);

        if (!is_null($cache) && (time() - $cache->creadeTime) < 60) {
            throw new ValidatorInvalidParamsException('请一分钟后再次请求');
        }

        //设置缓存
        $smsCodeCache = new SmsCodeCache($smsDto->phone);
        $smsCodeCache->creadeTime = time();
        $smsCodeCache->code =(string)mt_rand(1000,9999);
        $this->redisUtils->setObject($smsCodeCache,300);

        $this->smsService->sendSmsVerifiCode($smsCodeCache->code, 5, $smsDto->phone);
    }
}
