<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Menus;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class AdminMenuListResponseDto extends AbstractResponseDtoTransformer
{
    public array $items;
}
