<?php
declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends AbstractLogicException
{
    public $code = self::UNAUTHORIZED_ERROR;

    public $message = '未授权';

    public int $httpStatusCode = Response::HTTP_UNAUTHORIZED;
}
