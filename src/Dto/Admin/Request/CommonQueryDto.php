<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use DateTimeInterface;
use JMS\Serializer\Annotation as Serializer;

class CommonQueryDto extends AbstractRequestDtoTransformer
{
    public int $type = 0;

    public int $page = 1;

    public int $pageSize = 10;

    public string $searchKey = '';

    /**
     * @var array<DateTimeInterface>
     * @Serializer\Type("array<DateTimeInterface<'Y-m-d H:i:s','+8'>>")
     */
    public array $searchTime = [];

    public int $identity = 0;

    public ?int $state = null;

    public string $id = '';

    public string $deptId = '';
}
