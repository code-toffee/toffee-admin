<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Dto\Admin\Response\Menus\AdminMenuMetaDto;
use App\Dto\Admin\Response\Menus\AdminMenusDto;
use App\Entity\AdminMenu;

class BuildMenuTreeTask
{
    /**
     * @var AdminMenu[]
     */
    private array $menuOriginDataMap;

    /**
     * @param AdminMenu[] $data
     * @return AdminMenusDto[]
     */
    public function run(array $data): array
    {
        /**
         * @var AdminMenusDto[] $menus
         */
        $menus = [];
        if (empty($data)) {
            return $menus;
        }

        $getResult = function ($v) {
            return empty($v) ? null : $v;
        };

        foreach ($data as $menu) {
            $buildMenu = new AdminMenusDto();
            $buildMeta = new AdminMenuMetaDto();
            $buildMenu->id = $this->generateFullPath($menu);
            $buildMenu->pid = !empty($menu->getPid()) ? $this->generateParentPath($buildMenu->id) : null;
            $buildMenu->permission = $menu->getPermission();
            $buildMenu->status = $menu->isStatus();
            $buildMenu->createdTime = $menu->getCreatedTime()->format('Y-m-d H:i:s');

            $buildMenu->meta = $buildMeta;

            $buildMenu->path = $menu->getPath();
            $buildMenu->component = $menu->getComponent();
            $buildMenu->name = $getResult($menu->getName());
            $buildMenu->redirect = $getResult($menu->getRedirect());

            $buildMenu->meta->title = $menu->getTitle();
            $buildMenu->meta->orderNo = $getResult($menu->getMenuSort());
            $buildMenu->meta->ignoreKeepAlive = $getResult($menu->getIgnoreRoute());
            $buildMenu->meta->affix = $getResult($menu->getAffix());
            $buildMenu->meta->icon = $getResult($menu->getIcon());
            $buildMenu->meta->frameSrc = $getResult($menu->getFramePath());
            $buildMenu->meta->hideBreadcrumb = $getResult($menu->getHideBreadcrumb());
            $buildMenu->meta->hideChildrenInMenu = $getResult($menu->getHideChildrenInMenu());
            $buildMenu->meta->currentActiveMenu = $getResult($menu->getCurrentActiveMenu());
            $buildMenu->meta->hideTab = $getResult($menu->getHideTab());
            $buildMenu->meta->hideMenu = $getResult($menu->getHideMenu());
            $buildMenu->meta->ignoreRoute = $getResult($menu->getIgnoreRoute());
            $buildMenu->meta->hidePathForChildren = $getResult($menu->getHidePathForChildren());

            $menus[] = $buildMenu;
            if (!empty($menu->getChilden())) {
                $buildMenu->children = $this->run($menu->getChilden());
            }
        }
        return $menus;
    }

    private function generateFullPath(AdminMenu $menu): string
    {
        if (empty($menu->getPid())) {
            return $menu->getId() . '';
        }
        $pidObj = $this->menuOriginDataMap[$menu->getPid()];
        $tmp = $pidObj->getId() . '-' . $menu->getId();
        if (!empty($pidObj->getPid())) {
            $tmp = $this->generateFullPath($pidObj) . '-' . $menu->getId();
        }
        return $tmp;
    }

    private function generateParentPath(string $path): string
    {
        $index = strripos($path, '-');
        if ($index === false) {
            return $path;
        }
        return substr($path, 0, $index);
    }

    /**
     * @param AdminMenu[] $deptOriginDataMap
     * @return self
     */
    public function setDeptOriginDataMap(array $deptOriginDataMap): self
    {
        $this->menuOriginDataMap = $deptOriginDataMap;
        return $this;
    }
}
