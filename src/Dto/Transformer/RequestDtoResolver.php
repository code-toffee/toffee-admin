<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

use App\Exceptions\ValidatorInvalidParamsException;
use Doctrine\Common\Annotations\Reader;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    private Reader $reader;

    /**
     * @param ValidatorInterface $validator
     * @param Reader $reader
     */
    public function __construct(ValidatorInterface $validator, Reader $reader)
    {
        $this->validator = $validator;
        $this->reader = $reader;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $reflection = new ReflectionClass($argument->getType());
        if ($reflection->implementsInterface(RequestDtoTransformerInterface::class)) {
            return true;
        }
        return false;
    }

    /**
     * @throws ReflectionException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();

        $contentType = $request->headers->get('Content-Type');

        $isJson = !empty($contentType) && strpos($contentType, 'json');

        if ($request->getMethod() === 'GET') {
            $data = $serializer->serialize($request->query->all(), 'json');
        } elseif ($request->getMethod() === 'POST' && $isJson) {
            $data = $request->getContent();
        } else {
            $data = $serializer->serialize($request->request->all(), 'json');
        }

        [$controller, $method] = explode('::', $request->attributes->get('_controller'));
        $ref = new ReflectionMethod($controller, $method);
        $validatorGroup = $this->reader->getMethodAnnotation($ref, ValidatorGroup::class);

        $dto = $serializer->deserialize($data, $argument->getType(), 'json');

        if ($validatorGroup) {
            $this->validate($dto, $validatorGroup->getGroups());
        } else {
            $this->validate($dto);
        }

        yield $dto;
    }

    public function validate($dto, $group = null)
    {
        $errors = $this->validator->validate($dto, null, $group);
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            $error = $errors->get(0);
            throw new ValidatorInvalidParamsException($error->getMessage());
        }
    }
}
