<?php

namespace App\Repository;

use App\Dto\Admin\Request\DeptStructRequstDto;
use App\Entity\AdminDept;
use App\Entity\AdminRoleDepts;
use App\Task\Admin\ParsePathIdTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method AdminDept|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminDept|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminDept[]    findAll()
 * @method AdminDept[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminDeptRepository extends ServiceEntityRepository
{
    private ParsePathIdTask $parsePathIdTask;

    public function __construct(ManagerRegistry $registry, ParsePathIdTask $parsePathIdTask)
    {
        parent::__construct($registry, AdminDept::class);
        $this->parsePathIdTask = $parsePathIdTask;
    }

    /**
     * @param DeptStructRequstDto $dto
     * @return AdminDept
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addDept(DeptStructRequstDto $dto): AdminDept
    {
        $pid = $this->parsePathIdTask->run($dto->pid);

        $dept = new AdminDept();
        $dept->setPid((int)$pid)
            ->setName($dto->name)
            ->setDeptSort($dto->orderNo)
            ->setRemark($dto->remark)
            ->setStatus($dto->status);
        $this->_em->persist($dept);
        $this->_em->flush($dept);
        return $dept;
    }

    /**
     * @param DeptStructRequstDto $dto
     * @return AdminDept|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateDept(DeptStructRequstDto $dto): ?AdminDept
    {
        $id = $this->parsePathIdTask->run($dto->id);
        $pid = $this->parsePathIdTask->run($dto->pid);

        $dept = $this->find((int)$id);
        if (!$dept) {
            return null;
        }

        $dept->setStatus($dto->status)
            ->setPid($pid)
            ->setRemark($dto->remark)
            ->setDeptSort($dto->orderNo)
            ->setName($dto->name);
        $this->_em->persist($dept);
        $this->_em->flush($dept);

        return $dept;
    }

    /**
     * @param string[] $ids
     * @throws Exception
     */
    public function deleteDept(array $ids)
    {
        $this->_em->beginTransaction();

        try {
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminDept::class, 'd')
                ->where($qb->expr()->in('d.id', ':ids'))
                ->setParameter(':ids', $ids);
            $qb->getQuery()->execute();

            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminRoleDepts::class, 'ard')
                ->where($qb->expr()->in('ard.deptId', ':ids'))
                ->setParameter(':ids', $ids);
            $qb->getQuery()->execute();
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw new $exception();
        }
    }
}
