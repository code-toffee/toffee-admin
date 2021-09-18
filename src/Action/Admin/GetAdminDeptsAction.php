<?php
declare(strict_types=1);

namespace App\Action\Admin;

use App\Entity\AdminDept;
use App\Repository\AdminDeptRepository;
use App\Task\Admin\BuildDeptTreeTask;
use App\Utils\TreeBuildUtils;
use Exception;

class GetAdminDeptsAction
{
    private AdminDeptRepository $adminDeptRepository;

    private TreeBuildUtils $treeBuildUtils;

    private BuildDeptTreeTask $buildDeptTreeTask;

    /**
     * @param AdminDeptRepository $adminDeptRepository
     * @param TreeBuildUtils $treeBuildUtils
     * @param BuildDeptTreeTask $buildDeptTreeTask
     */
    public function __construct(
        AdminDeptRepository $adminDeptRepository,
        TreeBuildUtils $treeBuildUtils,
        BuildDeptTreeTask $buildDeptTreeTask
    ) {
        $this->adminDeptRepository = $adminDeptRepository;
        $this->treeBuildUtils = $treeBuildUtils;
        $this->buildDeptTreeTask = $buildDeptTreeTask;
    }

    /**
     * @return AdminDept[]
     * @throws Exception
     */
    public function run(): array
    {
        $data = $this->adminDeptRepository->findBy([], ['deptSort' => 'ASC', 'createdTime' => 'ASC']);

        if (empty($data)) {
            return [];
        }

        $tree = $this->treeBuildUtils
            ->setStoreMapData(true)
            ->setPid(0)
            ->setData($data)
            ->setIndexCall('getId')
            ->setPidCall('getPid')
            ->setMappingIndex('id')
            ->setStoreCall('setChilden')
            ->objectBuildTree();
        return $this->buildDeptTreeTask
            ->setDeptOriginDataMap($this->treeBuildUtils->getMapData())
            ->run($tree);
    }
}
