<?php
declare(strict_types=1);

namespace App\Tests\TestCase\Dto\Response;

use App\Dto\Transformer\AbstractResponseDtoTransformer;

class ResponseTestDemoDto extends AbstractResponseDtoTransformer
{
    public string $createTime;
}
