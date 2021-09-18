<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class AdminRoleResponseDto extends AbstractResponseDtoTransformer
{
    public int $value;

    public string $name;

    public int $level;

    public string $dataScope;

    public string $description;
}
