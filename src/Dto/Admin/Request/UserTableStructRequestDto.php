<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class UserTableStructRequestDto extends AbstractRequestDtoTransformer
{
    /**
     * @Assert\NotBlank(message="id不能为空",groups={"update","delete","detail"})
     */
    public int $id;

    /**
     * @Assert\NotBlank(message="密码不能为空",groups={"add"})
     */
    public ?string $password = null;

    /**
     * @Assert\NotBlank(message="账号不能为空",groups={"add"})
     */
    public ?string $userName = null;

    public string $deptPath = '';

    /**
     * @var int[]
     * @Serializer\Type("array<int>")
     */
    public array $roleIds = [];

    public string $realName = '';

    public string $phone = '';

    public bool $isAdmin = false;

    public bool $state = true;

    public string $homePath = '';
}
