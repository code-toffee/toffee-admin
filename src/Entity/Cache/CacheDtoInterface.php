<?php
declare(strict_types=1);

namespace App\Entity\Cache;

interface CacheDtoInterface
{
    public function getCacheKey(): string;

    public function setCacheKey(...$arg);
}
