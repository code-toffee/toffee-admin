<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Annotation\LogAction;
use App\Message\AdminLogMessage;
use App\Security\AdminUserProvider;
use Doctrine\Common\Annotations\Reader;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class LoggerAnnotationSubscriber implements EventSubscriberInterface
{
    private Security $security;

    private Reader $reader;

    private MessageBusInterface $messageBus;

    /**
     * @param Security $security
     * @param Reader $reader
     * @param MessageBusInterface $messageBus
     */
    public function __construct(Security $security, Reader $reader, MessageBusInterface $messageBus)
    {
        $this->security = $security;
        $this->reader = $reader;
        $this->messageBus = $messageBus;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return
            [
                KernelEvents::RESPONSE => ['onKernelResponse'],
            ];
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $user = $this->security->getUser();
        if (empty($user)) {
            return;
        }

        $request = $event->getRequest();
        [$controller, $method] = explode('::', $request->attributes->get('_controller'));
        try {
            $ref = new ReflectionMethod($controller, $method);
            $logAction = $this->reader->getMethodAnnotation($ref, LogAction::class);
            if (empty($logAction)) {
                return;
            }
            if ($user instanceof AdminUserProvider) {
                $message = new AdminLogMessage();
                $message->setLogName($logAction->getName());
                $message->setResponse($event->getResponse());
                $message->setMethod($request->getMethod());
                $message->setContent($request->getContent());
                $message->setHeaderBag($request->headers);
                $message->setParameterBag($request->attributes);
                $message->setServerBag($request->server);
                if ($request->getMethod() === 'POST') {
                    $message->setInputBag($request->request);
                } else {
                    $message->setInputBag($request->query);
                }
                $message->setUserId($user->getAdminUserCache()->id);
                $this->messageBus->dispatch($message);
            }
        } catch (ReflectionException $e) {
            return;
        }
    }
}
