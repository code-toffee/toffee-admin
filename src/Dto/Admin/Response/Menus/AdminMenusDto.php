<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Menus;

use JMS\Serializer\Annotation as Serializer;

class AdminMenusDto
{
    public string $id;

    public ?string $pid;

    public ?string $permission;

    public ?bool $status;

    public string $path;

    public string $component;

    public AdminMenuMetaDto $meta;

    public ?string $name = null;

    public ?string $redirect = null;

    /**
     * @var self[]
     * @Serializer\Type("array<App\Dto\Admin\Response\Menus\AdminMenusDto>")
     */
    public ?array $children = null;

    public string $createdTime;
}
