<?php

namespace App\Tests\Controller\Api;

use App\Controller\Api\ApiTestController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestControllerTest extends WebTestCase
{
    public function testTest()
    {
        $client = static::createClient();
        $client->request('GET','/api/test');
        $this->assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());
    }
}
