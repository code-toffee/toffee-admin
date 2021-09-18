<?php

namespace App\Entity;

use App\Repository\AdminMenuRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdminMenuRepository::class)
 * @ORM\Table(
 *     options={"comment"="菜单表"},
 *     indexes={
 *      @ORM\Index(name="permission_idx",columns={"permission"})
 *      }
 *     )
 */
class AdminMenu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer",options={"comment"="上级菜单ID","default"=0})
     */
    private int $pid = 0;

    /**
     * @ORM\Column(type="integer",options={"comment"="菜单类型 1-目录，2-菜单，3-按钮"})
     */
    private int $type;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否启用","default"=true})
     */
    private bool $status = true;

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="权限标识符","default"=""})
     */
    private string $permission = '';

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="链接地址","default"=""})
     */
    private string $path = '';

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="重定向","default"=""})
     */
    private string $redirect = '';

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="组件名称","default"=""})
     */
    private string $name = '';

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="组件","default"=""})
     */
    private string $component = '';

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="菜单标题"})
     */
    private string $title;

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="图标","default"=""})
     */
    private string $icon = '';

    /**
     * @ORM\Column(type="integer",options={"comment"="排序","default"=1})
     */
    private int $menuSort = 1;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否外链","default"=false})
     */
    private bool $iFrame = false;

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="frame链接地址","default"=""})
     */
    private string $framePath = '';

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否启用缓存","default"=false})
     */
    private bool $cache = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否隐藏","default"=false})
     */
    private bool $hidden = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否忽略KeepAlive缓存","default"=false})
     */
    private bool $ignoreKeepAlive = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否固定在标签上","default"=false})
     */
    private bool $affix = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否隐藏该路由在面包屑上面的显示","default"=false})
     */
    private bool $hideBreadcrumb = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否隐藏所有子菜单","default"=false})
     */
    private bool $hideChildrenInMenu = false;

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="当前激活的菜单。用于配置详情页时左侧激活的菜单路径","default"=""})
     */
    private string $currentActiveMenu = '';

    /**
     * @ORM\Column(type="boolean",options={"comment"="当前路由是否不在标签页显示","default"=false})
     */
    private bool $hideTab = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="当前路由是否不在菜单中显示","default"=false})
     */
    private bool $hideMenu = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否生成对应的菜单而忽略路由","default"=false})
     */
    private bool $ignoreRoute = false;

    /**
     * @ORM\Column(type="boolean",options={"comment"="是否在子级菜单的完整path中忽略本级path","default"=false})
     */
    private bool $hidePathForChildren = false;

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

    /**
     * @return AdminMenu[]|null
     */
    public function getChilden(): ?array
    {
        return $this->childen ?? [];
    }

    public function setChilden(?AdminMenu $childen): self
    {
        $this->childen[] = $childen;
        return $this;
    }

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

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function setPermission(string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getRedirect(): string
    {
        return $this->redirect;
    }

    public function setRedirect(string $redirect): self
    {
        $this->redirect = $redirect;

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

    public function getComponent(): string
    {
        return $this->component;
    }

    public function setComponent(string $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getMenuSort(): int
    {
        return $this->menuSort;
    }

    public function setMenuSort(int $menuSort): self
    {
        $this->menuSort = $menuSort;

        return $this;
    }

    public function getIFrame(): bool
    {
        return $this->iFrame;
    }

    public function setIFrame(bool $iFrame): self
    {
        $this->iFrame = $iFrame;

        return $this;
    }

    public function getFramePath(): string
    {
        return $this->framePath;
    }

    public function setFramePath(string $framePath): self
    {
        $this->framePath = $framePath;
        return $this;
    }

    public function getCache(): bool
    {
        return $this->cache;
    }

    public function setCache(bool $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getIgnoreKeepAlive(): bool
    {
        return $this->ignoreKeepAlive;
    }

    public function setIgnoreKeepAlive(bool $ignoreKeepAlive): self
    {
        $this->ignoreKeepAlive = $ignoreKeepAlive;

        return $this;
    }

    public function getAffix(): bool
    {
        return $this->affix;
    }

    public function setAffix(bool $affix): self
    {
        $this->affix = $affix;

        return $this;
    }

    public function getHideBreadcrumb(): bool
    {
        return $this->hideBreadcrumb;
    }

    public function setHideBreadcrumb(bool $hideBreadcrumb): self
    {
        $this->hideBreadcrumb = $hideBreadcrumb;

        return $this;
    }

    public function getHideChildrenInMenu(): bool
    {
        return $this->hideChildrenInMenu;
    }

    public function setHideChildrenInMenu(bool $hideChildrenInMenu): self
    {
        $this->hideChildrenInMenu = $hideChildrenInMenu;

        return $this;
    }

    public function getCurrentActiveMenu(): string
    {
        return $this->currentActiveMenu;
    }

    public function setCurrentActiveMenu(string $currentActiveMenu): self
    {
        $this->currentActiveMenu = $currentActiveMenu;

        return $this;
    }

    public function getHideTab(): bool
    {
        return $this->hideTab;
    }

    public function setHideTab(bool $hideTab): self
    {
        $this->hideTab = $hideTab;

        return $this;
    }

    public function getHideMenu(): bool
    {
        return $this->hideMenu;
    }

    public function setHideMenu(bool $hideMenu): self
    {
        $this->hideMenu = $hideMenu;

        return $this;
    }

    public function getIgnoreRoute(): bool
    {
        return $this->ignoreRoute;
    }

    public function setIgnoreRoute(bool $ignoreRoute): self
    {
        $this->ignoreRoute = $ignoreRoute;

        return $this;
    }

    public function getHidePathForChildren(): bool
    {
        return $this->hidePathForChildren;
    }

    public function setHidePathForChildren(bool $hidePathForChildren): self
    {
        $this->hidePathForChildren = $hidePathForChildren;

        return $this;
    }

    public function getCreatedTime(): DateTimeInterface
    {
        return $this->createdTime;
    }

    public function getUpdatedTime(): DateTimeInterface
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
