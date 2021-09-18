<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\DeptStructRequstDto;
use App\Repository\AdminDeptRepository;
use App\Task\Admin\ParsePathIdTask;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AddDeptAction
{
    private AdminDeptRepository $deptRepository;

    private ParsePathIdTask $parsePathIdTask;

    /**
     * @param AdminDeptRepository $deptRepository
     * @param ParsePathIdTask $parsePathIdTask
     */
    public function __construct(AdminDeptRepository $deptRepository, ParsePathIdTask $parsePathIdTask)
    {
        $this->deptRepository = $deptRepository;
        $this->parsePathIdTask = $parsePathIdTask;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(DeptStructRequstDto $dto)
    {
        $dto->pid = $this->parsePathIdTask->run($dto->pid);
        $this->deptRepository->addDept($dto);
    }
}
