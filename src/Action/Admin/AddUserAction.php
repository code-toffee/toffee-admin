<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AddUserAction
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
        $user = $this->adminUserRepository->findBy(['userName' => $dto->userName]);
        if (!empty($user)) {
            throw new ValidatorInvalidParamsException('账号已存在');
        }
        $this->adminUserRepository->addUser($dto);
    }
}
