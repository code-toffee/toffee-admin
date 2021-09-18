<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Entity\AdminUser;
use App\Entity\Cache\AdminUserCache;

class CheckIsAdminRoleTask
{
    public function run(object $userObject): bool
    {
        if ($userObject instanceof AdminUserCache) {
            return $this->checkUserFormCache($userObject);
        } elseif ($userObject instanceof AdminUser) {
            return $this->checkUserFormEntity($userObject);
        }
        return false;
    }

    private function checkUserFormCache(AdminUserCache $adminUserCache): bool
    {
        return $adminUserCache->isAdmin;
    }

    private function checkUserFormEntity(AdminUser $adminUser): bool
    {
        return $adminUser->isAdmin();
    }
}
