<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class RoleStructRequestDto extends AbstractRequestDtoTransformer
{
    /**
     * @Assert\NotBlank(message="id 不能为空",groups={"update","delete"})
     */
    public int $id;

    /**
     * @Assert\NotBlank(message="name 不能为空",groups={"update","add"})
     */
    public string $name;

    public int $level = 1;

    public string $description = '';

    public string $dataScope = '全部';

    /**
     * @var string[]
     * @Serializer\Type("array<string>")
     */
    public array $dept = [];

    /**
     * @var string[]
     * @Serializer\Type("array<string>")
     */
    public array $menu = [];
}
