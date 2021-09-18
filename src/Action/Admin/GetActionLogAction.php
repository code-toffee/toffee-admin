<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Repository\AdminLogRepository;
use App\Security\AdminUserProvider;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GetActionLogAction
{
    private AdminLogRepository $adminLogRepository;

    private AdminUserProvider $adminUserProvider;

    /**
     * @param AdminLogRepository $adminLogRepository
     * @param AdminUserProvider $adminUserProvider
     */
    public function __construct(AdminLogRepository $adminLogRepository, AdminUserProvider $adminUserProvider)
    {
        $this->adminLogRepository = $adminLogRepository;
        $this->adminUserProvider = $adminUserProvider;
    }

    public function run(CommonQueryDto $dto): Paginator
    {
        return $this->adminLogRepository->getLogsList($dto, $this->adminUserProvider->getAdminUserCache());
    }
}
