<?php
declare(strict_types=1);

namespace App\Entity\Cache;

use JMS\Serializer\Annotation as Serializer;

class ImgCaptchaCache extends AbstractCacheDto
{
    /**
     * @Serializer\Exclude
     */
    protected string $cacheKey="img_code_%s";

    public string $code;

    public function __construct(string $key)
    {
        $this->setCacheKey($key);
    }
}
