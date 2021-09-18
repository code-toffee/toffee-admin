<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class ChargePwdRequestDto extends AbstractRequestDtoTransformer
{
    /**
     * @var string
     * @Assert\NotBlank(message="旧密码不能为空")
     * @Assert\Length(min=6,max=18,maxMessage="密码长度应为6~18为",minMessage="密码长度应为6~18为")
     */
    public string $oldPwd;

    /**
     * @var string
     * @Assert\NotBlank(message="新密码不能为空")
     * @Assert\Length(min=6,max=18,maxMessage="密码长度应为6~18为",minMessage="密码长度应为6~18为")
     */
    public string $newPwd;
}
