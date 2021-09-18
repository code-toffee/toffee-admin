<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Role;

use JMS\Serializer\Annotation as Serializer;

class AdminRoleListItemDto
{
    public int $id;

    public string $name;

    public int $level;

    public string $description;

    public string $dataScope;

    public string $createdTime;

    /**
     * @Serializer\Type("array<string>")
     */
    public array $deptIds;

    /**
     * @Serializer\Type("array<string>")
     */
    public array $menuIds;
}
