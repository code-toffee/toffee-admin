<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class MenuStructRequstDto extends AbstractRequestDtoTransformer
{
    /**
     * @Assert\NotBlank(message="id 不能为空",groups={"update"})
     */
    public string $id;

    /**
     * @Assert\NotBlank(message="id 不能为空",groups={"update","add"})
     */
    public int $type;

    /**
     * @Assert\NotBlank(message="id 不能为空",groups={"update","add"})
     */
    public string $title;

    public string $path = '';

    public string $redirect = '';

    public string $pid = '0';

    public bool $status = true;

    public string $component = '';

    public string $name = '';

    public int $orderNo = 1;

    public string $icon = '';

    public string $permission = '';

    public bool $iFrame = false;

    public string $framePath = '';

    public bool $cache = false;

    public bool $hideMenu = false;

    /**
     * 由前端遍历汇总的此节点及其下级所有节点的值,格式为 ['1','1-2','1-2-3']
     * @var string[]
     *
     * @Assert\Sequentially(constraints={
     *     @Assert\NotBlank(message="ids 不能为空"),
     *     @Assert\Type("array",message="ids 格式错误")
     * },groups={"delete"})
     *
     * @Serializer\Type("array<string>")
     */
    public array $ids;
}
