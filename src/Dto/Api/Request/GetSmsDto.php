<?php
declare(strict_types=1);

namespace App\Dto\Api\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class GetSmsDto extends AbstractRequestDtoTransformer
{
    /**
     * 手机号
     * @Assert\NotBlank(message="手机号不能为空")
     * @Assert\Length(min=11,max=14,minMessage="手机号格式有误",maxMessage="手机号格式有误")
     */
    public string $phone;



    /**
     * 图形验证码key
     * @Assert\NotBlank(message="图形验证码不能为空")
     */
    public string $key;


    /**
     * 图形验证码code
     * @Assert\NotBlank(message="图形验证码不能为空")
     */
    public string $code;
}
