<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UpdateUserAction
{
    private AdminUserRepository $adminUserRepository;

    /**
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(UserTableStructRequestDto $dto)
    {
        $this->adminUserRepository->updateUser($dto);
    }
}
