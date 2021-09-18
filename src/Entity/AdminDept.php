<?php

namespace App\Entity;

use App\Repository\AdminDeptRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdminDeptRepository::class)
 * * @ORM\Table(
 *     options={"comment"="部门表"},
 *     indexes={
 *      @ORM\Index(name="pid_idx",columns={"pid"})
 *      }
 *     )
 */
class AdminDept
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer",options={"comment"="上级部门","default"=0})
     */
    private int $pid = 0;

    /**
     * @ORM\Column(type="string", length=255,options={"comment"="部门名称","default"=""})
     */
    private string $name = '';

    /**
     * @ORM\Column(type="string", length=255,options={"comment"="备注","default"=""})
     */
    private string $remark = '';

    /**
     * @ORM\Column(type="integer",options={"comment"="部门排序","default"=1})
     */
    private int $deptSort = 1;

    /**
     * @ORM\Column(type="boolean",options={"comment"="状态,1-启用,2-禁用","default"=1})
     */
    private bool $status = true;

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
     * @var self[]|null
     */
    private ?array $childen;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPid(): int
    {
        return $this->pid;
    }

    public function setPid(int $pid): self
    {
        $this->pid = $pid;
        return $this;
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

    public function getRemark(): string
    {
        return $this->remark;
    }

    public function setRemark(string $remark): self
    {
        $this->remark = $remark;
        return $this;
    }

    public function getDeptSort(): int
    {
        return $this->deptSort;
    }

    public function setDeptSort(int $deptSort): self
    {
        $this->deptSort = $deptSort;
        return $this;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
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

    public function getChilden(): ?array
    {
        return $this->childen ?? [];
    }

    public function setChilden(AdminDept $childen): self
    {
        $this->childen[] = $childen;
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
