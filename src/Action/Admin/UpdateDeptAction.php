<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\DeptStructRequstDto;
use App\Repository\AdminDeptRepository;
use App\Task\Admin\ParsePathIdTask;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UpdateDeptAction
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(DeptStructRequstDto $dto)
    {
        $dto->id = $this->parsePathIdTask->run($dto->id);
        $dto->pid = $this->parsePathIdTask->run($dto->pid);
        $this->adminDeptRepository->updateDept($dto);
    }
}
