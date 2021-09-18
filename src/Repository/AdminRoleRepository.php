<?php

namespace App\Repository;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Dto\Admin\Request\RoleStructRequestDto;
use App\Entity\AdminRole;
use App\Entity\AdminRoleDepts;
use App\Entity\AdminRoleMenus;
use App\Entity\AdminUser;
use App\Entity\AdminUserRoles;
use App\Task\Admin\ParsePathIdTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method AdminRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminRole[]    findAll()
 * @method AdminRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRoleRepository extends ServiceEntityRepository
{
    private ParsePathIdTask $parsePathIdTask;

    private AdminUserRolesRepository $adminUserRolesRepository;

    public function __construct(
        ManagerRegistry $registry,
        ParsePathIdTask $parsePathIdTask,
        AdminUserRolesRepository $adminUserRolesRepository
    ) {
        parent::__construct($registry, AdminRole::class);
        $this->parsePathIdTask = $parsePathIdTask;
        $this->adminUserRolesRepository = $adminUserRolesRepository;
    }

    /**
     * @param CommonQueryDto $dto
     * @return Paginator
     */
    public function getList(CommonQueryDto $dto): Paginator
    {
        $offset = ($dto->page - 1) * $dto->pageSize;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('r')
            ->from(AdminRole::class, 'r');
        $qb->setMaxResults($dto->pageSize)->setFirstResult($offset);
        return new Paginator($qb, false);
    }

    /**
     * @throws Exception
     */
    public function deleteRole(int $id)
    {
        $this->_em->beginTransaction();
        try {
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminRole::class, 'r')
                ->where('r.id = :id')
                ->setParameter(':id', $id);
            $qb->getQuery()->execute();
            $this->deleteDeptRelation($id);
            $this->deleteMenuRelation($id);
            $this->deleteUserRelation($id);
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw $exception;
        }
    }

    /**
     * @param RoleStructRequestDto $dto
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addRole(RoleStructRequestDto $dto)
    {
        $this->_em->beginTransaction();
        try {
            $role = new AdminRole();
            $role->setName($dto->name);
            $role->setLevel($dto->level);
            $role->setDescription($dto->description);
            $role->setDataScope($dto->dataScope);
            $this->_em->persist($role);
            $this->_em->flush();
            $this->addRoleDepts($role, $dto);
            $this->addRoleMenus($role, $dto);
            $this->_em->commit();
        } catch (Exception $ex) {
            $this->_em->rollback();
            throw $ex;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateRole(RoleStructRequestDto $dto)
    {
        $role = $this->find($dto->id);
        if (empty($role)) {
            return;
        }
        $this->_em->beginTransaction();
        try {
            $role->setName($dto->name);
            $role->setDataScope($dto->dataScope);
            $role->setDescription($dto->description);
            $role->setLevel($dto->level);
            $this->_em->persist($role);
            $this->_em->flush();
            $this->deleteDeptRelation($role->getId());
            $this->deleteMenuRelation($role->getId());
            $this->addRoleDepts($role, $dto);
            $this->addRoleMenus($role, $dto);
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw new $exception;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addRoleDepts(AdminRole $role, RoleStructRequestDto $dto)
    {
        if (!empty($dto->dept)) {
            foreach ($dto->dept as $item) {
                $deptId = $this->parsePathIdTask->run($item);
                $roleMenu = new AdminRoleDepts();
                $roleMenu->setDeptId((int)$deptId);
                $roleMenu->setRoleId($role->getId());
                $this->_em->persist($roleMenu);
            }
            $this->_em->flush();
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addRoleMenus(AdminRole $role, RoleStructRequestDto $dto)
    {
        if (!empty($dto->menu)) {
            foreach ($dto->menu as $item) {
                $menuId = $this->parsePathIdTask->run($item);
                $roleMenu = new AdminRoleMenus();
                $roleMenu->setMenuId((int)$menuId);
                $roleMenu->setRoleId($role->getId());
                $this->_em->persist($roleMenu);
            }
            $this->_em->flush();
        }
    }

    private function deleteDeptRelation(int $roleId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->delete(AdminRoleDepts::class, 'ard')
            ->where('ard.roleId = :id')
            ->setParameter(':id', $roleId);
        $qb->getQuery()->execute();
    }

    private function deleteMenuRelation(int $roleId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->delete(AdminRoleMenus::class, 'arm')
            ->where('arm.roleId = :id')
            ->setParameter(':id', $roleId);
        $qb->getQuery()->execute();
    }

    private function deleteUserRelation(int $roleId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->delete(AdminUserRoles::class, 'aur')
            ->where('aur.roleId = :id')
            ->setParameter(':id', $roleId);
        $qb->getQuery()->execute();
    }

    /**
     * @param AdminUser $user
     * @return AdminRole[]
     */
    public function getRolesByUser(AdminUser $user): array
    {
        $roleids = $this->adminUserRolesRepository->findBy(['userId' => $user->getId()]);
        if (empty($roleids)) {
            return [];
        }
        $roleids = array_column($roleids, 'roleId');

        $qb = $this->_em->createQueryBuilder();
        $qb->select('r')
            ->from(AdminRole::class, 'r')
            ->where($qb->expr()->in('r.id', $roleids));
        return $qb->getQuery()->getResult();
    }
}
