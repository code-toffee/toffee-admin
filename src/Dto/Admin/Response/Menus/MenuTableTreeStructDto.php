<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Menus;

use JMS\Serializer\Annotation as Serializer;

class MenuTableTreeStructDto
{
    public string $id;

    public int $type;

    public string $title;

    public ?string $pid = null;

    public ?string $path = null;

    public ?string $redirect = null;

    public ?string $component = null;

    public ?string $name = null;

    public int $orderNo = 1;

    public ?string $icon = null;

    public ?string $permission = null;

    public ?string $framePath = null;

    public bool $status = true;

    public bool $iFrame = false;

    public bool $cache = false;

    public bool $hideMenu = false;

    /**
     * @var self[]
     * @Serializer\Type("array<App\Dto\Admin\Response\Menus\MenuTableTreeStructDto>")
     */
    public ?array $children = null;

    public string $createdTime;
}
