<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Menus;

class AdminMenuMetaDto
{
    public ?int $orderNo = null; // 菜单排序，只对第一级有效

    public string $title; // title

    public ?bool $ignoreKeepAlive = null; //是否不缓存

    public ?bool $affix = null;  // 它是否固定在标签上

    public ?string $icon = null; // 图标，也是菜单图标

    public ?string $frameSrc = null; // 内嵌iframe的地址

    public ?bool $hideBreadcrumb = null; // 隐藏该路由在面包屑上面的显示

    public ?bool $hideChildrenInMenu = null; // 隐藏所有子菜单

    public ?string $currentActiveMenu = null; // 当前激活的菜单。用于配置详情页时左侧激活的菜单路径

    public ?bool $hideTab = null; // 当前路由不再标签页显示

    public ?bool $hideMenu = null; // 当前路由不再菜单显示

    public ?bool $ignoreRoute = null; // 忽略路由。用于在ROUTE_MAPPING以及BACK权限模式下，生成对应的菜单而忽略路由。2.5.3以上版本有效

    public ?bool $hidePathForChildren = null; // 是否在子级菜单的完整path中忽略本级path。2.5.3以上版本有效
}
