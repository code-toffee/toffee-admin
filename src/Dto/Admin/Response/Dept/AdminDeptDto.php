<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response\Dept;

use JMS\Serializer\Annotation as Serializer;

class AdminDeptDto
{
    public string $id;

    public ?string $pid;

    public int $orderNo;

    public string $name;

    public string $createTime;

    public string $remark;

    public bool $status;

    /**
     * @var self[]
     * @Serializer\Type("array<App\Dto\Admin\Response\Dept\AdminDeptDto>")
     */
    public ?array $children = null;
}
