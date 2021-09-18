<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiTestController
 * @package App\Controller\Api
 *
 * @Route("/api",defaults={"anonymous":true})
 */
class ApiTestController extends AbstractController
{
    /**
     * @Route("/test",methods={"POST","GET"})
     */
    public function test(): Response
    {
        return $this->json('ok');
    }
}
