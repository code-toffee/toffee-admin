<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

use JMS\Serializer\SerializerBuilder;

abstract class AbstractDtoTransformer implements DtoSerializeInterface
{
    public function serialize(): string
    {
        $serialize = SerializerBuilder::create()->build();
        return $serialize->serialize($this, 'json');
    }
}
