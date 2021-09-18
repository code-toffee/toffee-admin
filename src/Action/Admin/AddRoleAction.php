<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\RoleStructRequestDto;
use App\Repository\AdminRoleRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AddRoleAction
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
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(RoleStructRequestDto $dto)
    {
        $this->adminRoleRepository->addRole($dto);
    }
}
