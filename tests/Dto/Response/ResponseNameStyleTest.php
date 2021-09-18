<?php
declare(strict_types=1);

namespace App\Tests\Dto\Response;

use App\Tests\TestCase\Dto\Response\ResponseTestDemoDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResponseNameStyleTest extends KernelTestCase
{
    /**
     * 测试响应的数据结构是否正常，以及字段名是否符合命名规范
     */
    public function testResponseNameStyle()
    {
        $response = new ResponseTestDemoDto();
        $response->createTime = "create time test";
        $correctCase = '{"code":0,"message":"ok","result":{"createTime":"create time test"}}';
        $this->assertSame($correctCase,$response->transformerResponse()->getContent());
    }
}
