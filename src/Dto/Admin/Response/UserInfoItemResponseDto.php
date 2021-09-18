<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

use App\Dto\Admin\Response\Menus\MenuTableTreeStructDto;
use App\Dto\Transformer\AbstractResponseDtoTransformer;

class UserInfoItemResponseDto extends AbstractResponseDtoTransformer
{
    public int $id;

    public string $deptPath;

    public string $userName;

    public string $realName;

    public string $phone;

    public bool $isAdmin;

    public bool $state;

    public ?array $roleIds = null;

    public string $createdTime;

    public string $homePath;

    /**
     * @var string[]|null
     */
    public ?array $rolesName = null;

    public ?string $deptName = null;

    /**
     * @var string[]|null
     */
    public ?array $permCode = null;

    /**
     * @var MenuTableTreeStructDto[]|null
     */
    public ?array $menuList = null;
}
