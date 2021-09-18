<?php

namespace App\Entity;

use App\Repository\AdminRoleRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdminRoleRepository::class)
 * @ORM\Table(options={"comment"="角色表"})
 */
class AdminRole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255,options={"comment"="角色名称"})
     */
    private string $name;

    /**
     * @ORM\Column(type="integer",options={"comment"="角色级别，越小越大最小为1，下级角色无法操作上级角色数据","default"=1})
     */
    private int $level = 1;

    /**
     * @ORM\Column(type="string", length=255,options={"comment"="角色描述"})
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255,options={"comment"="数据权限"})
     */
    private string $dataScope;

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

    /**
     * @var string[]|null
     */
    private ?array $deptIds = null;

    /**
     * @var string[]|null
     */
    private ?array $menuIds = null;

    public function getDeptIds(): ?array
    {
        return $this->deptIds;
    }

    public function setDeptIds(?array $deptIds): self
    {
        $this->deptIds = $deptIds;
        return $this;
    }

    public function pushDeptIds(string $deptId): self
    {
        $this->deptIds[] = $deptId;
        return $this;
    }

    public function getMenuIds(): ?array
    {
        return $this->menuIds;
    }

    public function setMenuIds(?array $menuIds): self
    {
        $this->menuIds = $menuIds;
        return $this;
    }

    public function pushMenuIds(string $menuId): self
    {
        $this->menuIds[] = $menuId;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDataScope(): string
    {
        return $this->dataScope;
    }

    public function setDataScope(string $dataScope): self
    {
        $this->dataScope = $dataScope;

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

    public function __get($name)
    {
        return $this->$name;
    }

    public function __isset($prop): bool
    {
        return isset($this->$prop);
    }
}
