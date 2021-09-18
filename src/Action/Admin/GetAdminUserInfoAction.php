<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Entity\Cache\AdminUserCache;
use App\Security\AdminUserProvider;

class GetAdminUserInfoAction
{
    private AdminUserProvider $adminUserProvider;

    /**
     * @param AdminUserProvider $adminUserProvider
     */
    public function __construct(AdminUserProvider $adminUserProvider)
    {
        $this->adminUserProvider = $adminUserProvider;
    }

    public function run(): AdminUserCache
    {
        return $this->adminUserProvider->getAdminUserCache();
    }
}
