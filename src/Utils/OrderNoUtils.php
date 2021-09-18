<?php
declare(strict_types=1);

namespace App\Utils;

class OrderNoUtils
{
    /**
     * P+年月日时分秒+用户手机号后2位倒数+用户手机号后3位倒数
     * P20210122151122111
     *
     * @param string $userPhone
     * @return string
     */
    public static function generatePayTradeNo(string $userPhone): string
    {
        $phoneEnd1 = substr($userPhone, -2, 2);
        $phoneEnd2 = substr($userPhone, -3, 3);

        $phoneEnd1 = strrev($phoneEnd1);
        $phoneEnd2 = strrev($phoneEnd2);

        $date = date('YmdHis', time());
        return sprintf("P%s%s%s", $date, $phoneEnd1, $phoneEnd2);
    }
}
