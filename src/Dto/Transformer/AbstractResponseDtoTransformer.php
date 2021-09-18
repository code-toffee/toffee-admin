<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

use Closure;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseDtoTransformer extends AbstractDtoTransformer
{
    public function transArrayObjects(iterable $objects, Closure $closure):iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $closure($object);
        }


        return $dto;
    }


    public function transformerResponse($code = 0, $msg = 'ok'): Response
    {
        $a = new stdClass();
        $a->code = $code;
        $a->message = $msg;
        $a->result = $this;

        $serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
        $json = $serializer->serialize($a, 'json');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
