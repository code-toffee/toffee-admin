<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Repository\AdminUserRepository;

class DeleteUserAction
{
    private AdminUserRepository $adminUserRepository;

    /**
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    public function run(UserTableStructRequestDto $dto)
    {
        $this->adminUserRepository->deleteUser($dto->id);
    }
}
