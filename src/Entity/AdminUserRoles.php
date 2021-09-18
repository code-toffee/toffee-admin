<?php

namespace App\Entity;

use App\Repository\AdminUserRolesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminUserRolesRepository::class)
 * @ORM\Table(options={"comment"="管理员用户角色关联表"},indexes={@ORM\Index(name="role_idx",columns={"role_id"})})
 */
class AdminUserRoles
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="用户Id"})
     */
    private int $userId;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="角色id"})
     */
    private int $roleId;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return AdminUserRoles
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     * @return AdminUserRoles
     */
    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __isset($prop): bool
    {
        return isset($this->$prop);
    }
}
