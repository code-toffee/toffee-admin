<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\RoleStructRequestDto;
use App\Repository\AdminRoleRepository;

class UpdateRoleAction
{
    private AdminRoleRepository $adminRoleRepository;

    /**
     * @param AdminRoleRepository $adminRoleRepository
     */
    public function __construct(AdminRoleRepository $adminRoleRepository)
    {
        $this->adminRoleRepository = $adminRoleRepository;
    }

    public function run(RoleStructRequestDto $dto)
    {
        $this->adminRoleRepository->updateRole($dto);
    }
}
