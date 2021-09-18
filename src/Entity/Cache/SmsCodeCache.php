<?php
declare(strict_types=1);

namespace App\Entity\Cache;

use JMS\Serializer\Annotation as Serializer;

class SmsCodeCache extends AbstractCacheDto
{
    /**
     * @Serializer\Exclude
     */
    protected string $cacheKey="sms_code_%s";

    public string $code;

    public int $creadeTime;

    public function __construct(string $phone)
    {
        $this->setCacheKey($phone);
    }
}
