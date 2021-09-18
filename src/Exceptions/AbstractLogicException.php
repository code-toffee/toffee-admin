<?php
declare(strict_types=1);

namespace App\Exceptions;

use LogicException;

abstract class AbstractLogicException extends LogicException
{
    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    public int $httpStatusCode;


    // 参数错误
    public const PARAMETER_ERROR = -1;
    // 未授权
    public const UNAUTHORIZED_ERROR = -401;
    // 无权限
    public const PAYMENT_ERROR = -403;
    // 不存在
    public const NOTFOUND_ERROR = -404;

}
