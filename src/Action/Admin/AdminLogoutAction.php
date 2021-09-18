<?php
declare(strict_types=1);

namespace App\Action\Admin;


use App\Security\AdminUserProvider;
use App\Task\Admin\UpdateAdminUserInfoCacheTask;
use ReflectionException;

class AdminLogoutAction
{
    private AdminUserProvider $adminUserProvider;

    private UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask;

    /**
     * @param AdminUserProvider $adminUserProvider
     * @param UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
     */
    public function __construct(
        AdminUserProvider $adminUserProvider,
        UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
    ) {
        $this->adminUserProvider = $adminUserProvider;
        $this->updateAdminUserInfoCacheTask = $updateAdminUserInfoCacheTask;
    }

    /**
     * @throws ReflectionException
     */
    public function run()
    {
        $this->updateAdminUserInfoCacheTask
            ->preRemoveToken($this->adminUserProvider->getCredentials())
            ->run($this->adminUserProvider->getAdminUserCache());
    }
}
