<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

interface DtoSerializeInterface
{
    public function serialize(): string;
}
