<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Entity\AdminDept;
use App\Entity\AdminMenu;
use App\Entity\AdminRole;
use App\Repository\AdminDeptRepository;
use App\Repository\AdminMenuRepository;
use App\Repository\AdminRoleDeptsRepository;
use App\Repository\AdminRoleMenusRepository;
use App\Repository\AdminRoleRepository;
use Exception;

class GetRolesListAction
{
    private AdminRoleRepository $adminRoleRepository;

    private AdminDeptRepository $adminDeptRepository;

    private AdminRoleDeptsRepository $adminRoleDeptsRepository;

    private AdminRoleMenusRepository $adminRoleMenusRepository;

    private AdminMenuRepository $adminMenuRepository;

    /**
     * @param AdminRoleRepository $adminRoleRepository
     * @param AdminDeptRepository $adminDeptRepository
     * @param AdminRoleDeptsRepository $adminRoleDeptsRepository
     * @param AdminRoleMenusRepository $adminRoleMenusRepository
     * @param AdminMenuRepository $adminMenuRepository
     */
    public function __construct(
        AdminRoleRepository $adminRoleRepository,
        AdminDeptRepository $adminDeptRepository,
        AdminRoleDeptsRepository $adminRoleDeptsRepository,
        AdminRoleMenusRepository $adminRoleMenusRepository,
        AdminMenuRepository $adminMenuRepository
    ) {
        $this->adminRoleRepository = $adminRoleRepository;
        $this->adminDeptRepository = $adminDeptRepository;
        $this->adminRoleDeptsRepository = $adminRoleDeptsRepository;
        $this->adminRoleMenusRepository = $adminRoleMenusRepository;
        $this->adminMenuRepository = $adminMenuRepository;
    }

    /**
     * @param CommonQueryDto $dto
     * @return array
     * @throws Exception
     */
    public function run(CommonQueryDto $dto): ?array
    {
        $pg = $this->adminRoleRepository->getList($dto);
        $roleResult = $pg->getQuery()->getResult();
        $result = ['result' => $roleResult, 'count' => $pg->count()];
        /**
         * @var AdminRole[] $roleMaps
         */
        $roleMaps = array_column($roleResult, null, 'id');
        $roleDepts = $this->adminRoleDeptsRepository->findAll();
        $roleMenus = $this->adminRoleMenusRepository->findAll();

        foreach ($roleDepts as $item) {
            if (isset($roleMaps[$item->getRoleId()])) {
                $roleMaps[$item->getRoleId()]->pushDeptIds($item->getDeptId() . '');
            }
        }
        foreach ($roleMenus as $item) {
            if (isset($roleMaps[$item->getRoleId()])) {
                $roleMaps[$item->getRoleId()]->pushMenuIds($item->getMenuId() . '');
            }
        }

        $depts = $this->adminDeptRepository->findAll();
        $deptMaps = array_column($depts, null, 'id');
        $menus = $this->adminMenuRepository->findAll();
        $menuMaps = array_column($menus, null, 'id');

        foreach ($roleMaps as $role) {
            if (!empty($role->getDeptIds())) {
                $tmp = [];
                foreach ($role->getDeptIds() as $deptIdValue) {
                    $tmp[] = $this->generateFullPath($deptMaps, $deptIdValue);
                }
                $role->setDeptIds($tmp);
            }

            if (!empty($role->getMenuIds())) {
                $tmp = [];
                foreach ($role->getMenuIds() as $menuIdValue) {
                    $tmp[] = $this->generateFullPath($menuMaps, $menuIdValue);
                }
                $role->setMenuIds($tmp);
            }
        }
        return $result;
    }

    /**
     * @param AdminDept[]|AdminMenu[] $map
     * @param string $id
     * @return string
     */
    private function generateFullPath(array $map, string $id): string
    {
        if (empty($map[$id])) {
            return '';
        }
        if (empty($map[$id]->getPid())) {
            return $id;
        }
        $path = $map[$id]->getPid() . '-' . $id;

        if (!empty($map[$id]->getPid())) {
            $path = $this->generateFullPath($map, $map[$id]->getPid() . '') . '-' . $id;
        }
        return $path;
    }
}
