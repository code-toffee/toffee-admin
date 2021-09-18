<?php

namespace App\Entity;

use App\Repository\AdminRoleDeptsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRoleDeptsRepository::class)
 * @ORM\Table(options={"comment"="角色部门关联表"},indexes={@ORM\Index(name="role_idx",columns={"role_id"})})
 */
class AdminRoleDepts
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="部门id"})
     */
    private int $deptId;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="角色id"})
     */
    private int $roleId;

    public function getDeptId(): int
    {
        return $this->deptId;
    }

    public function setDeptId(int $deptId): self
    {
        $this->deptId = $deptId;
        return $this;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }
}
