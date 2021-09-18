<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Repository\AdminUserRepository;
use App\Security\AdminUserProvider;
use App\Task\Admin\CheckIsAdminRoleTask;

class GetUserPermCodesAction
{
    private AdminUserRepository $adminUserRepository;

    private AdminUserProvider $adminUserProvider;

    private CheckIsAdminRoleTask $checkIsAdminRoleTask;

    /**
     * @param AdminUserRepository $adminUserRepository
     * @param AdminUserProvider $adminUserProvider
     * @param CheckIsAdminRoleTask $checkIsAdminRoleTask
     */
    public function __construct(
        AdminUserRepository $adminUserRepository,
        AdminUserProvider $adminUserProvider,
        CheckIsAdminRoleTask $checkIsAdminRoleTask
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminUserProvider = $adminUserProvider;
        $this->checkIsAdminRoleTask = $checkIsAdminRoleTask;
    }

    public function run(): array
    {
        //todo::补充角色与菜单关联的权限标识符缓存。
        $sessionUser = $this->adminUserProvider->getAdminUserCache();
        if ($this->checkIsAdminRoleTask->run($sessionUser)) {
            return ['admin'];
        }
        $rolesArr = ($this->adminUserRepository->getUserPermCodes($sessionUser->id));
        return array_column($rolesArr, 'permission');
    }
}
