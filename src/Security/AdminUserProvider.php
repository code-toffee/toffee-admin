<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\AdminUser;
use App\Entity\Cache\AdminUserCache;
use App\Repository\AdminUserRepository;
use App\Utils\TokenUtils\TokenDto;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserProvider implements UserInterface
{
    private AdminUserCache $adminUserCache;

    private TokenDto $tokenDto;

    private AdminUserRepository $userRepository;

    private string $credentials;

    /**
     * @param AdminUserRepository $userRepository
     */
    public function __construct(AdminUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return string
     */
    public function getCredentials(): string
    {
        return $this->credentials;
    }

    /**
     * @param string $credentials
     * @return AdminUserProvider
     */
    public function setCredentials(string $credentials): self
    {
        $this->credentials = $credentials;
        return $this;
    }

    /**
     * @param AdminUserCache $adminUserCache
     * @return AdminUserProvider
     */
    public function setAdminUserCache(AdminUserCache $adminUserCache): self
    {
        $this->adminUserCache = $adminUserCache;
        return $this;
    }

    /**
     * @return TokenDto
     */
    public function getTokenDto(): TokenDto
    {
        return $this->tokenDto;
    }

    /**
     * @param TokenDto $tokenDto
     * @return AdminUserProvider
     */
    public function setTokenDto(TokenDto $tokenDto): self
    {
        $this->tokenDto = $tokenDto;
        return $this;
    }

    public function getAdminUserEntity(): ?AdminUser
    {
        return $this->userRepository->find($this->adminUserCache->id);
    }

    /**
     * @return AdminUserCache
     */
    public function getAdminUserCache(): AdminUserCache
    {
        return $this->adminUserCache;
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->adminUserCache->userName;
    }
}
