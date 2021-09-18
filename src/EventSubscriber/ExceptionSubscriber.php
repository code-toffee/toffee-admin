<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exceptions\AbstractLogicException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    protected ContainerBagInterface $params;

    protected LoggerInterface $logger;

    /**
     * ExceptionSubscriber constructor.
     * @param ContainerBagInterface $params
     * @param LoggerInterface $logger
     */
    public function __construct(ContainerBagInterface $params, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $debug = $this->params->get('kernel.debug');
        $exception = $event->getThrowable();
        $report = [
            'message'  => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        $this->logger->error('异常',
            [
                'message'   => $exception->getMessage(),
                'code'  => $exception->getCode(),
                'trace' => $exception->getTrace()
            ]
        );

        if (!$exception instanceof AbstractLogicException) {
            $report = [
                'message'  => '服务器内部错误',
                'code' => -1,
            ];
        }

        if ($debug) {
            dump($event);
            $report ['debug'] = $event->getThrowable()->getMessage();
            $report ['trace'] = $event->getThrowable()->getTrace();
        }

        $response = new JsonResponse();
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            if (property_exists($exception, 'httpStatusCode')) {
                $response->setStatusCode($exception->httpStatusCode);
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $response->setData($report);

        $event->setResponse($response);
    }
}
