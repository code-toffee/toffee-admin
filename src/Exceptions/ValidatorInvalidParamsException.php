<?php
declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ValidatorInvalidParamsException extends AbstractLogicException
{
    public $code = self::PARAMETER_ERROR;

    public $message = '参数错误';

    public int $httpStatusCode = Response::HTTP_BAD_REQUEST;
}
