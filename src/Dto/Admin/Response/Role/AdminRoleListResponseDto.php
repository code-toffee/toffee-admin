<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Role;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class AdminRoleListResponseDto extends AbstractResponseDtoTransformer
{
    public array $items;
}
