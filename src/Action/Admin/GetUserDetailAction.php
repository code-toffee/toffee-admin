<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Exceptions\NotFoundException;
use App\Repository\AdminDeptRepository;
use App\Repository\AdminMenuRepository;
use App\Repository\AdminRoleRepository;
use App\Repository\AdminUserRepository;
use App\Task\Admin\BuildMenuTableTreeTask;
use App\Utils\TreeBuildUtils;
use Exception;

class GetUserDetailAction
{
    private AdminUserRepository $adminUserRepository;

    private AdminDeptRepository $adminDeptRepository;

    private AdminRoleRepository $adminRoleRepository;

    private TreeBuildUtils $treeBuildUtils;

    private BuildMenuTableTreeTask $buildMenuTableTreeTask;

    private AdminMenuRepository $adminMenuRepository;

    /**
     * @param AdminUserRepository $adminUserRepository
     * @param AdminDeptRepository $adminDeptRepository
     * @param AdminRoleRepository $adminRoleRepository
     * @param TreeBuildUtils $treeBuildUtils
     * @param BuildMenuTableTreeTask $buildMenuTableTreeTask
     * @param AdminMenuRepository $adminMenuRepository
     */
    public function __construct(
        AdminUserRepository $adminUserRepository,
        AdminDeptRepository $adminDeptRepository,
        AdminRoleRepository $adminRoleRepository,
        TreeBuildUtils $treeBuildUtils,
        BuildMenuTableTreeTask $buildMenuTableTreeTask,
        AdminMenuRepository $adminMenuRepository
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminDeptRepository = $adminDeptRepository;
        $this->adminRoleRepository = $adminRoleRepository;
        $this->treeBuildUtils = $treeBuildUtils;
        $this->buildMenuTableTreeTask = $buildMenuTableTreeTask;
        $this->adminMenuRepository = $adminMenuRepository;
    }

    /**
     * @throws Exception
     */
    public function run(UserTableStructRequestDto $dto): array
    {
        //用户信息
        $user = $this->adminUserRepository->find($dto->id);
        if (empty($user)) {
            throw new NotFoundException('用户不存在');
        }
        //用户所属角色
        $roles = $this->adminRoleRepository->getRolesByUser($user);
        //用户所在部门
        $dept = $this->adminDeptRepository->find($user->getDeptId());
        //权限码列表
        $permCode = [];
        //拥有的菜单列表
        if ($user->isAdmin()) {
            $menus = $this->adminMenuRepository->findAll();
            $permCode[] = '超级管理员';
        } else {
            $menus = $this->adminUserRepository->getUserDetailMenus($user, $roles);
        }

        foreach ($menus as $menu) {
            if (!empty($menu->getPermission())) {
                $permCode [] = $menu->getPermission();
            }
        }

        $tree = $this->treeBuildUtils
            ->setStoreMapData(true)
            ->setPid(0)
            ->setData($menus)
            ->setIndexCall('getId')
            ->setPidCall('getPid')
            ->setMappingIndex('id')
            ->setStoreCall('setChilden')
            ->objectBuildTree();
        $menus = $this->buildMenuTableTreeTask
            ->setDeptOriginDataMap($this->treeBuildUtils->getMapData())
            ->run($tree);

        return [
            'user'     => $user,
            'roles'    => $roles,
            'dept'     => $dept,
            'permCode' => $permCode,
            'menus'    => $menus
        ];
    }
}
