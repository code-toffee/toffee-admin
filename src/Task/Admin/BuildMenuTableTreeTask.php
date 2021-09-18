<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Dto\Admin\Response\Menus\AdminMenusDto;
use App\Dto\Admin\Response\Menus\MenuTableTreeStructDto;
use App\Entity\AdminMenu;

class BuildMenuTableTreeTask
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
            $buildMenu = new MenuTableTreeStructDto();
            $buildMenu->type = $menu->getType();
            $buildMenu->id = $this->generateFullPath($menu);
            $buildMenu->title = $menu->getTitle();
            $buildMenu->pid = !empty($menu->getPid()) ? $this->generateParentPath($buildMenu->id) : null;
            $buildMenu->path = $getResult($menu->getPath());
            $buildMenu->redirect = $getResult($menu->getRedirect());
            $buildMenu->component = $getResult($menu->getComponent());
            $buildMenu->name = $getResult($menu->getName());
            $buildMenu->orderNo = $menu->getMenuSort();
            $buildMenu->icon = $getResult($menu->getIcon());
            $buildMenu->permission = $getResult($menu->getPermission());
            $buildMenu->framePath = $getResult($menu->getFramePath());
            $buildMenu->status = $menu->isStatus();
            $buildMenu->iFrame = $menu->getIFrame();
            $buildMenu->cache = $menu->getCache();
            $buildMenu->hideMenu = $menu->getHideMenu();
            $buildMenu->createdTime = $menu->getCreatedTime()->format('Y-m-d H:i:s');
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
