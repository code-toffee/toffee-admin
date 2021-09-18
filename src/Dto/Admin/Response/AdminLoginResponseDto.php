<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

class AdminLoginResponseDto extends AdminUserResponseDto
{
    public string $token;

    public string $loginTime;
}
