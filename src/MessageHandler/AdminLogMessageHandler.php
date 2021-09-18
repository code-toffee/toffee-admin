<?php

namespace App\MessageHandler;

use App\Message\AdminLogMessage;
use App\Repository\AdminLogRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AdminLogMessageHandler implements MessageHandlerInterface
{
    private AdminLogRepository $adminLogRepository;

    /**
     * @param AdminLogRepository $adminLogRepository
     */
    public function __construct(AdminLogRepository $adminLogRepository)
    {
        $this->adminLogRepository = $adminLogRepository;
    }

    public function __invoke(AdminLogMessage $message)
    {
        $this->adminLogRepository->addLogging($message);
    }
}
