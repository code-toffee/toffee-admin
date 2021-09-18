<?php

namespace App\Tests\Utils;

use App\Utils\InvitaionCode;
use PHPUnit\Framework\TestCase;

class InvitaionCodeTest extends TestCase
{
    /**
     * 数据提供器
     * @return array[]
     */
    public function userIdProvider(): array
    {
        return [
            [mt_rand(1, 999)],
            [mt_rand(999, 999999)],
            [mt_rand(999999, 999999999)],
            [mt_rand(999999999, 999999999999)],
        ];
    }

    /**
     * 测试邀请码的生成和解析
     * @dataProvider userIdProvider
     */
    public function testGenerateInviationCode(int $id)
    {
        $invitaionCode = new InvitaionCode();
        $enCode = $invitaionCode->encode((string)$id);
        $deCode = $invitaionCode->decode($enCode);
        $this->assertEquals($deCode, $id);
    }

}
