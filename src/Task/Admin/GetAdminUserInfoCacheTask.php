<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Entity\Cache\AdminUserCache;
use App\Utils\RedisUtils;

class GetAdminUserInfoCacheTask
{
    private RedisUtils $redisUtils;

    /**
     * @param RedisUtils $redisUtils
     */
    public function __construct(RedisUtils $redisUtils)
    {
        $this->redisUtils = $redisUtils;
    }

    /**
     * @param string $userId
     * @return AdminUserCache|null
     */
    public function run(string $userId): ?AdminUserCache
    {
        return $this->redisUtils->getObject(AdminUserCache::class, $userId);
    }
}
