<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use App\Repository\AdminUserRolesRepository;

class GetUserTableListAction
{
    private AdminUserRepository $adminUserRepository;

    private AdminUserRolesRepository $adminUserRolesRepository;

    /**
     * @param AdminUserRepository $adminUserRepository
     * @param AdminUserRolesRepository $adminUserRolesRepository
     */
    public function __construct(
        AdminUserRepository $adminUserRepository,
        AdminUserRolesRepository $adminUserRolesRepository
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminUserRolesRepository = $adminUserRolesRepository;
    }

    public function run(CommonQueryDto $dto): array
    {
        $userRoles = $this->adminUserRolesRepository->findAll();
        $userRoleMap = [];
        foreach ($userRoles as $item) {
            $userRoleMap[$item->getUserId()][] = $item->getRoleId();
        }
        $paginator = $this->adminUserRepository->getUserList($dto);
        /**
         * @var AdminUser[] $result
         */
        $result = $paginator->getQuery()->getResult();
        $count = $paginator->count();
        foreach ($result as $item) {
            if (isset($userRoleMap[$item->getId()])) {
                $item->setRoleIds($userRoleMap[$item->getId()]);
            }
        }

        return ['result' => $result, 'count' => $count];
    }
}
