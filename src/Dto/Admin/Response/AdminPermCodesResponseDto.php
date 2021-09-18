<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class AdminPermCodesResponseDto extends AbstractResponseDtoTransformer
{
    /**
     * @var string[] $permCode
     */
    public array $permCode;
}
