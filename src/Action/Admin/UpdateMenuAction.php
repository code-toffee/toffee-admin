<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Dto\Admin\Request\MenuStructRequstDto;
use App\Repository\AdminMenuRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UpdateMenuAction
{
    private AdminMenuRepository $adminMenuRepository;

    /**
     * @param AdminMenuRepository $adminMenuRepository
     */
    public function __construct(AdminMenuRepository $adminMenuRepository)
    {
        $this->adminMenuRepository = $adminMenuRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function run(MenuStructRequstDto $dto)
    {
        $this->adminMenuRepository->updateMenu($dto);
    }
}
