<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

use JMS\Serializer\SerializerBuilder;
use Throwable;

abstract class AbstractRequestDtoTransformer extends AbstractDtoTransformer implements RequestDtoTransformerInterface
{
    public function toArray(): array
    {
        $serialize = SerializerBuilder::create()->build();
        try {
            return $serialize->toArray($this);
        } catch (Throwable $ex) {
            return [];
        }
    }
}
