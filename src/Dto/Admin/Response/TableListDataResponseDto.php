<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class TableListDataResponseDto extends AbstractResponseDtoTransformer
{
    public array $items;

    public int $total;

    public string $computed1 = '0';

    public string $computed2 = '0';

    public string $computed3 = '0';

    public string $computed4 = '0';
}
