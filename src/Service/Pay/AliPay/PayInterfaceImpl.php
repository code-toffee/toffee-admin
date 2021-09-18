<?php
declare(strict_types=1);

namespace App\Service\Pay\AliPay;

use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;
use App\Contract\PayInterface;
use App\Service\Pay\Dto\PayTradeDto;
use Exception;

class PayInterfaceImpl implements PayInterface
{
    public function __construct(
        string $appId,
        string $appPrivateKey,
        string $alipayPublicKey,
        string $notifyUrl,
        string $encryptKey
    ) {
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';
        // appId
        $options->appId = $appId;
        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = $appPrivateKey;
        // 支付宝公钥
        $options->alipayPublicKey = $alipayPublicKey;
        //可设置异步通知接收服务地址（可选）
        $options->notifyUrl = $notifyUrl;
        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        $options->encryptKey = $encryptKey;

        Factory::setOptions($options);
    }

    public function pay(string $subject, string $outTradeNo, string $amount, string $returnUrl = ''): PayTradeDto
    {
        $payData = Factory::payment()->page()->pay($subject, $outTradeNo, $amount, $returnUrl);

        $dto = new PayTradeDto();
        $dto->setOutputResponse(true);
        $dto->setBody($payData->body);
        return $dto;
    }

    public function verifyNotify(array $parameters): bool
    {
        try {
            return Factory::payment()->common()->verifyNotify($parameters);

        } catch (Exception $exception){
            return false;
        }
    }

    public function refund(string $outTradeNo,string $refundAmount)
    {
        try {
            $a = Factory::payment()->common()->refund($outTradeNo, $refundAmount);
            dump($a);
        } catch (Exception $e) {
            dump($e);
        }
    }
}
