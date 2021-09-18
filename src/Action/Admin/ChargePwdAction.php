<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\ChargePwdRequestDto;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Repository\AdminUserRepository;
use App\Security\AdminUserProvider;
use App\Task\Admin\UpdateAdminUserInfoCacheTask;
use App\Utils\PasswordSafeUtils;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ChargePwdAction
{
    private AdminUserProvider $adminUserProvider;

    private AdminUserRepository $adminUserRepository;

    private UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask;

    /**
     * @param AdminUserProvider $adminUserProvider
     * @param AdminUserRepository $adminUserRepository
     * @param UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
     */
    public function __construct(
        AdminUserProvider $adminUserProvider,
        AdminUserRepository $adminUserRepository,
        UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
    ) {
        $this->adminUserProvider = $adminUserProvider;
        $this->adminUserRepository = $adminUserRepository;
        $this->updateAdminUserInfoCacheTask = $updateAdminUserInfoCacheTask;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(ChargePwdRequestDto $dto)
    {
        $user = $this->adminUserProvider->getAdminUserEntity();
        $oldPwd = PasswordSafeUtils::generate($dto->oldPwd);

        if ($user->getPassword() !== $oldPwd) {
            throw new ValidatorInvalidParamsException("密码验证错误");
        }

        $this->adminUserRepository->chargePwd($user, $dto->newPwd);

        $this->updateAdminUserInfoCacheTask
            ->preFlushToken()
            ->run($user);
    }
}
