<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Response\Menus\AdminMenusDto;
use App\Repository\AdminMenuRepository;
use App\Repository\AdminUserRepository;
use App\Security\AdminUserProvider;
use App\Task\Admin\BuildMenuTreeTask;
use App\Task\Admin\CheckIsAdminRoleTask;
use App\Utils\TreeBuildUtils;
use Exception;

class GetMenusAction
{
    private AdminMenuRepository $adminMenuRepository;

    private TreeBuildUtils $treeBuildUtils;

    private AdminUserProvider $adminUserProvider;

    private CheckIsAdminRoleTask $checkIsAdminRoleTask;

    private AdminUserRepository $adminUserRepository;

    private BuildMenuTreeTask $buildMenuTreeTask;

    /**
     * @param AdminMenuRepository $adminMenuRepository
     * @param TreeBuildUtils $treeBuildUtils
     * @param AdminUserProvider $adminUserProvider
     * @param CheckIsAdminRoleTask $checkIsAdminRoleTask
     * @param AdminUserRepository $adminUserRepository
     * @param BuildMenuTreeTask $buildMenuTreeTask
     */
    public function __construct(
        AdminMenuRepository $adminMenuRepository,
        TreeBuildUtils $treeBuildUtils,
        AdminUserProvider $adminUserProvider,
        CheckIsAdminRoleTask $checkIsAdminRoleTask,
        AdminUserRepository $adminUserRepository,
        BuildMenuTreeTask $buildMenuTreeTask
    ) {
        $this->adminMenuRepository = $adminMenuRepository;
        $this->treeBuildUtils = $treeBuildUtils;
        $this->adminUserProvider = $adminUserProvider;
        $this->checkIsAdminRoleTask = $checkIsAdminRoleTask;
        $this->adminUserRepository = $adminUserRepository;
        $this->buildMenuTreeTask = $buildMenuTreeTask;
    }

    /**
     * @return AdminMenusDto[]
     * @throws Exception
     */
    public function run(): array
    {
        $sessionUser = $this->adminUserProvider->getAdminUserCache();

        if ($this->checkIsAdminRoleTask->run($sessionUser)) {
            $data = $this->adminMenuRepository->findBy(['type' => [1, 2]],
                ['menuSort' => 'ASC', 'createdTime' => 'ASC']);
        } else {
            //根据用户角色来来获取相关菜单
            $data = $this->adminUserRepository->getUserMenus($sessionUser);
        }
        if (empty($data)) {
            return [];
        }

        $tree = $this->treeBuildUtils
            ->setStoreMapData(true)
            ->setPid(0)
            ->setData($data)
            ->setIndexCall('getId')
            ->setPidCall('getPid')
            ->setMappingIndex('id')
            ->setStoreCall('setChilden')
            ->objectBuildTree();
        return $this->buildMenuTreeTask
            ->setDeptOriginDataMap($this->treeBuildUtils->getMapData())
            ->run($tree);
    }

}
