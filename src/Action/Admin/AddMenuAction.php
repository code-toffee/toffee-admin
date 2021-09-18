<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\MenuStructRequstDto;
use App\Repository\AdminMenuRepository;
use App\Task\Admin\ParsePathIdTask;

class AddMenuAction
{
    private AdminMenuRepository $adminMenuRepository;

    private ParsePathIdTask $parsePathIdTask;

    /**
     * @param AdminMenuRepository $adminMenuRepository
     * @param ParsePathIdTask $parsePathIdTask
     */
    public function __construct(AdminMenuRepository $adminMenuRepository, ParsePathIdTask $parsePathIdTask)
    {
        $this->adminMenuRepository = $adminMenuRepository;
        $this->parsePathIdTask = $parsePathIdTask;
    }

    public function run(MenuStructRequstDto $dto)
    {
        $dto->pid = $this->parsePathIdTask->run($dto->pid);

        $this->adminMenuRepository->addMenu($dto);
    }
}
