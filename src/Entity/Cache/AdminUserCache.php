<?php
declare(strict_types=1);

namespace App\Entity\Cache;

use App\Entity\AdminRole;
use DateTime;
use JMS\Serializer\Annotation as Serializer;

class AdminUserCache extends AbstractCacheDto
{
    /**
     * @Serializer\Exclude
     */
    protected string $cacheKey="admin_user_info_%s";


    /**
     * @Serializer\Type("array<string>")
     */
    public array $tokens;

    /**
     * @var AdminRole[] $roles
     * @Serializer\Type("array<App\Entity\AdminRole>")
     */
    public array $roles;

    public int $id;

    public bool $state;

    public string $phone;

    public string $userName;

    public string $realName;

    public bool $isAdmin;

    public string $homePath;

    public Datetime $loginDate;

    public function __construct($userId)
    {
        $this->setCacheKey($userId);
    }
}
