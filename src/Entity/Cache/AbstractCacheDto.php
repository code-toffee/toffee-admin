<?php
declare(strict_types=1);

namespace App\Entity\Cache;

use JMS\Serializer\Annotation as Serializer;

abstract class AbstractCacheDto implements CacheDtoInterface
{
    /**
     * @Serializer\Exclude
     */
    protected string $cacheKey;

    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }

    public function setCacheKey(...$arg)
    {
        $this->cacheKey = sprintf($this->cacheKey, ...$arg);
    }

}
