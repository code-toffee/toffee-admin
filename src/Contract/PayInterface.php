<?php

namespace App\Contract;

use App\Service\Pay\Dto\PayTradeDto;

interface PayInterface
{
    /**
     * 创建支付订单
     * @param string $subject
     * @param string $outTradeNo
     * @param string $amount
     * @param string $returnUrl
     * @return mixed
     */
    public function pay(string $subject, string $outTradeNo, string $amount, string $returnUrl = ''): PayTradeDto;

    /**
     * 验证回调
     * @param string[] $parameters
     * @return mixed
     */
    public function verifyNotify(array $parameters): bool;

    public function refund(string $outTradeNo,string $refundAmount);
}
