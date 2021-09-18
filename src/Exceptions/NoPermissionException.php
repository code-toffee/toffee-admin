<?php
declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class NoPermissionException extends AbstractLogicException
{
    public $code = self::PAYMENT_ERROR;

    public $message = '无权限';

    public int $httpStatusCode = Response::HTTP_FORBIDDEN;
}
