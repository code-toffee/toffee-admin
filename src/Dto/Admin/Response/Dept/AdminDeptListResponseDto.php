<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Dept;

use App\Dto\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class AdminDeptListResponseDto extends AbstractResponseDtoTransformer
{
    /**
     * @var AdminDeptDto[]
     * @Serializer\Type("array<App\Dto\Admin\Response\Dept\AdminDeptDto>")
     */
    public array $items;
}
