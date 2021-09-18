<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Entity\AdminRole;
use App\Repository\AdminRoleRepository;

class GetAllRoleListAction
{
    private AdminRoleRepository $adminRoleRepository;

    /**
     * @param AdminRoleRepository $adminRoleRepository
     */
    public function __construct(AdminRoleRepository $adminRoleRepository)
    {
        $this->adminRoleRepository = $adminRoleRepository;
    }

    /**
     * @return AdminRole[]
     */
    public function run(): array
    {
        return $this->adminRoleRepository->findAll();
    }
}
