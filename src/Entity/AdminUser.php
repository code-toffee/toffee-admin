<?php

namespace App\Entity;

use App\Repository\AdminUserRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdminUserRepository::class)
 * @ORM\Table(options={"comment"="管理员表"})
 */
class AdminUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer",options={"comment"="所属部门","default"=0})
     */
    private int $deptId = 0;

    /**
     * @ORM\Column(type="string", options={"comment"="部门路径","default"=""})
     */
    private string $deptPath = '';

    /**
     * @ORM\Column(type="string", length=15, unique=true, options={"comment"="账号"})
     */
    private string $userName;

    /**
     * @ORM\Column(type="string", length=15, unique=true, options={"comment"="真实姓名", "default"=""})
     */
    private string $realName = '';

    /**
     * @ORM\Column(type="string", length=80, options={"comment"="密码"})
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=15, options={"comment"="手机号", "default"=""})
     */
    private string $phone = '';

    /**
     * @ORM\Column(type="string", options={"comment"="首页path", "default"=""})
     */
    private string $homePath = '';

    /**
     * @ORM\Column(type="boolean", options={"comment"="是否为超级管理员", "default"=0})
     */
    private bool $isAdmin = false;

    /**
     * @ORM\Column(type="boolean", options={"comment"="用户状态【0冻结，1正常】", "default"=1})
     */
    private bool $state = true;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="创建时间"})
     * @Gedmo\Timestampable(on ="create")
     */
    private ?DateTimeInterface $createdTime;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="更新时间"})
     * @Gedmo\Timestampable(on ="update")
     */
    private ?DateTimeInterface $updatedTime;

    private ?array $roleIds = null;

    public function getRoleIds(): ?array
    {
        return $this->roleIds;
    }

    public function setRoleIds(?array $roleIds): self
    {
        $this->roleIds = $roleIds;
        return $this;
    }

    public function getDeptPath(): string
    {
        return $this->deptPath;
    }

    public function setDeptPath(string $deptPath): self
    {
        $this->deptPath = $deptPath;
        return $this;
    }

    public function pushRoleIds(int $id): self
    {
        $this->roleIds[] = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDeptId(): int
    {
        return $this->deptId;
    }

    public function setDeptId(int $deptId): self
    {
        $this->deptId = $deptId;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getRealName(): string
    {
        return $this->realName;
    }

    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getHomePath(): string
    {
        return $this->homePath;
    }

    public function setHomePath(string $homePath): self
    {
        $this->homePath = $homePath;
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    public function getState(): bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedTime(): ?DateTimeInterface
    {
        return $this->createdTime;
    }

    public function getUpdatedTime(): ?DateTimeInterface
    {
        return $this->updatedTime;
    }

}
