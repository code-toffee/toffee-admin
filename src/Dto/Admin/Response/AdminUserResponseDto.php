<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

use App\Dto\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class AdminUserResponseDto extends AbstractResponseDtoTransformer
{
    public int $id;

    public string $userName;

    public string $realName;

    public string $phone;

    /**
     * @var AdminRoleResponseDto[]
     * @Serializer\Type("array<App\Dto\Admin\Response\AdminRoleResponseDto>")
     */
    public array $roles;

    public ?string $homePath = null;
}
