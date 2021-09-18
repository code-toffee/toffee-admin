<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\MenuStructRequstDto;
use App\Repository\AdminMenuRepository;
use App\Task\Admin\ParsePathIdTask;

class DeleteMenuAction
{
    private ParsePathIdTask $parsePathIdTask;

    private AdminMenuRepository $adminMenuRepository;

    /**
     * @param ParsePathIdTask $parsePathIdTask
     * @param AdminMenuRepository $adminMenuRepository
     */
    public function __construct(ParsePathIdTask $parsePathIdTask, AdminMenuRepository $adminMenuRepository)
    {
        $this->parsePathIdTask = $parsePathIdTask;
        $this->adminMenuRepository = $adminMenuRepository;
    }

    public function run(MenuStructRequstDto $dto)
    {
        $ids = [];
        foreach ($dto->ids as $id) {
            $ids[] = $this->parsePathIdTask->run($id);
        }
        $this->adminMenuRepository->deleteMenu($ids);
    }
}
