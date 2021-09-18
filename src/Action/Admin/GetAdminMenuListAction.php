<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Repository\AdminMenuRepository;
use App\Task\Admin\BuildMenuTableTreeTask;
use App\Utils\TreeBuildUtils;
use Exception;

class GetAdminMenuListAction
{
    private AdminMenuRepository $adminMenuRepository;

    private TreeBuildUtils $treeBuildUtils;

    private BuildMenuTableTreeTask $buildMenuTableTreeTask;

    /**
     * @param AdminMenuRepository $adminMenuRepository
     * @param TreeBuildUtils $treeBuildUtils
     * @param BuildMenuTableTreeTask $buildMenuTableTreeTask
     */
    public function __construct(
        AdminMenuRepository $adminMenuRepository,
        TreeBuildUtils $treeBuildUtils,
        BuildMenuTableTreeTask $buildMenuTableTreeTask
    ) {
        $this->adminMenuRepository = $adminMenuRepository;
        $this->treeBuildUtils = $treeBuildUtils;
        $this->buildMenuTableTreeTask = $buildMenuTableTreeTask;
    }

    /**
     * @throws Exception
     */
    public function run(): array
    {
        $data = $this->adminMenuRepository->findBy([], ['menuSort' => 'ASC', 'createdTime' => 'ASC']);
        $tree = $this->treeBuildUtils
            ->setStoreMapData(true)
            ->setPid(0)
            ->setData($data)
            ->setIndexCall('getId')
            ->setPidCall('getPid')
            ->setMappingIndex('id')
            ->setStoreCall('setChilden')
            ->objectBuildTree();
        return $this->buildMenuTableTreeTask
            ->setDeptOriginDataMap($this->treeBuildUtils->getMapData())
            ->run($tree);
    }
}
