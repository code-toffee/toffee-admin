<?php
declare(strict_types=1);

namespace App\Security\Voters;

use App\Exceptions\NoPermissionException;
use App\Repository\AdminUserRepository;
use App\Security\AdminUserProvider;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdminPermissionVoter extends Voter
{
    private AdminUserProvider $adminUserProvider;

    private AdminUserRepository $adminUserRepository;

    /**
     * @param AdminUserProvider $adminUserProvider
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(AdminUserProvider $adminUserProvider, AdminUserRepository $adminUserRepository)
    {
        $this->adminUserProvider = $adminUserProvider;
        $this->adminUserRepository = $adminUserRepository;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return str_starts_with($attribute, 'roles(');
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $sessionUser = $this->adminUserProvider->getAdminUserCache();
        if ($sessionUser->isAdmin) {
            return true;
        }
        $arr = $this->parsingParameters($attribute);
        $rolesArr = ($this->adminUserRepository->getUserPermCodes($sessionUser->id));
        $rolesArr = array_column($rolesArr, 'permission');
        if (!empty(array_intersect($rolesArr, $arr))) {
            return true;
        } else {
            throw new NoPermissionException();
        }
    }

    private function parsingParameters(string $param): array
    {
        $start = strpos($param, '(');
        $tmp = substr($param, $start + 1, -1);
        return explode(',', $tmp);
    }
}
