<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Dto\Admin\Response\Dept\AdminDeptDto;
use App\Entity\AdminDept;

class BuildDeptTreeTask
{
    /**
     * @var AdminDept[]
     */
    private array $deptOriginDataMap;

    /**
     * @param AdminDept[] $data
     * @return AdminDeptDto[]
     */
    public function run(array $data): array
    {
        /**
         * @var AdminDeptDto[] $depts
         */
        $depts = [];
        if (empty($data)) {
            return $depts;
        }
        foreach ($data as $dept) {
            $buildDept = new AdminDeptDto();
            $buildDept->id = $this->generateFullPath($dept);
            $buildDept->pid = !empty($dept->getPid()) ? $this->generateParentPath($buildDept->id) : null;
            $buildDept->orderNo = $dept->getDeptSort();
            $buildDept->status = $dept->isStatus();
            $buildDept->name = $dept->getName();
            $buildDept->remark = $dept->getRemark();
            $buildDept->createTime = $dept->getCreatedTime()->format('Y-m-d H:i:s');
            $depts[] = $buildDept;
            if (!empty($dept->getChilden())) {
                $buildDept->children = $this->run($dept->getChilden());
            }
        }
        return $depts;
    }

    private function generateFullPath(AdminDept $dept): string
    {
        if (empty($dept->getPid())) {
            return $dept->getId() . '';
        }
        $pidObj = $this->deptOriginDataMap[$dept->getPid()];
        $tmp = $pidObj->getId() . '-' . $dept->getId();
        if (!empty($pidObj->getPid())) {
            $tmp = $this->generateFullPath($pidObj) . '-' . $dept->getId();
        }
        return $tmp;
    }

    private function generateParentPath(string $path): string
    {
        $index = strripos($path, '-');
        if ($index === false) {
            return $path;
        }
        return substr($path, 0, $index);
    }

    /**
     * @param AdminDept[] $deptOriginDataMap
     * @return BuildDeptTreeTask
     */
    public function setDeptOriginDataMap(array $deptOriginDataMap): self
    {
        $this->deptOriginDataMap = $deptOriginDataMap;
        return $this;
    }
}
