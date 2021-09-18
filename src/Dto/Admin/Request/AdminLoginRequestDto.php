<?php
declare(strict_types=1);

namespace App\Dto\Admin\Request;

use App\Dto\Transformer\AbstractRequestDtoTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class AdminLoginRequestDto extends AbstractRequestDtoTransformer
{
    /**
     * 账号
     * @Assert\NotBlank(message="账号不能为空")
     * @Assert\Length(min=1,max=15,maxMessage="账号长度不能超过15位")
     */
    public string $username;

    /**
     * 密码
     * @Assert\NotBlank(message="密码不能为空")
     * @Assert\Length(min=6,max=18,maxMessage="密码长度应为6~18为",minMessage="密码长度应为6~18为")
     */
    public string $password;

    /**
     * 验证码
     * @Assert\NotBlank(message="验证码不能为空")
     * @Assert\Length(min=1,max=4,maxMessage="验证码长度错误",minMessage="验证码长度错误")
     */
    public string $code;

    /**
     * 验证码key
     * @Assert\NotBlank(message="验证码数据异常")
     */
    public string $key;

    /**
     * 记住密码
     */
    public bool $remeber = false;
}
