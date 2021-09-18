<?php

namespace App\Entity;

use App\Repository\AdminRoleMenusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRoleMenusRepository::class)
 * @ORM\Table(options={"comment"="角色菜单关联表"},indexes={@ORM\Index(name="role_idx",columns={"role_id"})})
 */
class AdminRoleMenus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="菜单id"})
     */
    private int $menuId;


    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"comment"="角色id"})
     */
    private int $roleId;

    public function getMenuId(): int
    {
        return $this->menuId;
    }

    public function setMenuId(int $menuId): self
    {
        $this->menuId = $menuId;
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
