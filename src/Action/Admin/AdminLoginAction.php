<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\AdminLoginRequestDto;
use App\Exceptions\NotFoundException;
use App\Repository\AdminUserRepository;
use App\Task\Admin\UpdateAdminUserInfoCacheTask;
use App\Task\Api\CheckImgCodeTask;
use App\Utils\PasswordSafeUtils;
use App\Utils\TokenUtils\TokenUtils;
use ReflectionException;

class AdminLoginAction
{
    private CheckImgCodeTask $checkImgCodeTask;

    private AdminUserRepository $adminUserRepository;

    private TokenUtils $tokenUtils;

    private UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask;

    /**
     * @param CheckImgCodeTask $checkImgCodeTask
     * @param AdminUserRepository $adminUserRepository
     * @param TokenUtils $tokenUtils
     * @param UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
     */
    public function __construct(
        CheckImgCodeTask $checkImgCodeTask,
        AdminUserRepository $adminUserRepository,
        TokenUtils $tokenUtils,
        UpdateAdminUserInfoCacheTask $updateAdminUserInfoCacheTask
    ) {
        $this->checkImgCodeTask = $checkImgCodeTask;
        $this->adminUserRepository = $adminUserRepository;
        $this->tokenUtils = $tokenUtils;
        $this->updateAdminUserInfoCacheTask = $updateAdminUserInfoCacheTask;
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function run(AdminLoginRequestDto $dto): array
    {
        $this->checkImgCodeTask->run($dto->key, $dto->code);

        $admin = $this->adminUserRepository->findOneBy(['userName' => $dto->username]);

        if (is_null($admin)) {
            throw new NotFoundException('账号不存在');
        }

        if (!PasswordSafeUtils::verifyPassword($dto->password, $admin->getPassword())) {
            throw new NotFoundException('密码不正确');
        }

        if ($dto->remeber) {
            $token = $this->tokenUtils->generateToken((string)$admin->getId(), '+7 day');
        } else {
            $token = $this->tokenUtils->generateToken((string)$admin->getId());
        }

        //获取用户的菜单以及角色标签
        $roles = $this->adminUserRepository->getUserRoles($admin);

        $this->updateAdminUserInfoCacheTask
            ->preStoreUserRole($roles)
            ->preStoreToken($token)
            ->run($admin);
        return ['userInfo' => $admin, 'token' => $token, 'roles' => $roles];
    }
}
