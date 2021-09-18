<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\DeptStructRequstDto;
use App\Repository\AdminDeptRepository;
use App\Task\Admin\ParsePathIdTask;

class DeleteDeptAction
{
    private AdminDeptRepository $adminDeptRepository;

    private ParsePathIdTask $parsePathIdTask;

    /**
     * @param AdminDeptRepository $adminDeptRepository
     * @param ParsePathIdTask $parsePathIdTask
     */
    public function __construct(AdminDeptRepository $adminDeptRepository, ParsePathIdTask $parsePathIdTask)
    {
        $this->adminDeptRepository = $adminDeptRepository;
        $this->parsePathIdTask = $parsePathIdTask;
    }

    public function run(DeptStructRequstDto $dto)
    {
        $ids = [];
        foreach ($dto->ids as $id) {
            $ids[] = $this->parsePathIdTask->run($id);
        }
        $this->adminDeptRepository->deleteDept($ids);
    }
}
