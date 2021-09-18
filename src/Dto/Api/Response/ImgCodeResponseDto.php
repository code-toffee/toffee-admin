<?php
declare(strict_types=1);

namespace App\Dto\Api\Response;



use App\Dto\Transformer\AbstractResponseDtoTransformer;

class ImgCodeResponseDto extends AbstractResponseDtoTransformer
{
    public string $key;

    public string $imgData;
}
