<?php

namespace App\Repository;

use App\Dto\Admin\Request\CommonQueryDto;
use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Entity\AdminMenu;
use App\Entity\AdminRole;
use App\Entity\AdminRoleMenus;
use App\Entity\AdminUser;
use App\Entity\AdminUserRoles;
use App\Entity\Cache\AdminUserCache;
use App\Task\Admin\ParsePathIdTask;
use App\Utils\PasswordSafeUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method AdminUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminUser[]    findAll()
 * @method AdminUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminUserRepository extends ServiceEntityRepository
{
    private ParsePathIdTask $parsePathIdTask;

    public function __construct(
        ManagerRegistry $registry,
        ParsePathIdTask $parsePathIdTask
    ) {
        parent::__construct($registry, AdminUser::class);
        $this->parsePathIdTask = $parsePathIdTask;
    }

    /**
     * @param AdminUser $adminUser
     * @return AdminRole[]
     */
    public function getUserRoles(AdminUser $adminUser): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from(AdminRole::class, 'p')
            ->leftJoin(AdminUserRoles::class, 'r', Join::WITH, 'p.id = r.roleId')
            ->where('r.userId = :uid')->setParameter('uid', $adminUser->getId());
        return $qb->getQuery()->getResult();
    }

    public function getUserPermCodes(int $uid)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('distinct am.permission')
            ->from(AdminUserRoles::class, 'aur')
            ->leftJoin(AdminRoleMenus::class, 'arm', Join::WITH, 'arm.roleId = aur.roleId')
            ->leftJoin(AdminMenu::class, 'am', Join::WITH, 'am.id = arm.menuId')
            ->where('aur.userId = :uid')->setParameter('uid', $uid);
        return $qb->getQuery()->getArrayResult();
    }

    public function getUserMenus(AdminUserCache $adminUserCache)
    {
        $roles = $adminUserCache->roles;
        $roles = array_column($roles, 'id');

        $qb = $this->_em->createQueryBuilder();

        $qb->select('am')
            ->from(AdminMenu::class, 'am')
            ->leftJoin(AdminRoleMenus::class, 'arm', Join::WITH, 'arm.menuId = am.id')
            ->where($qb->expr()->in('arm.roleId', $roles))
            ->andWhere('am.type != 3')
            ->andWhere('am.status = 1')
            ->orderBy('am.menuSort', 'ASC')
            ->orderBy('am.createdTime', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function getUserList(CommonQueryDto $dto): Paginator
    {
        $offset = ($dto->page - 1) * $dto->pageSize;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from(AdminUser::class, 'u');

        if (!empty($dto->deptId)) {
            $deptId = $this->parsePathIdTask->run($dto->deptId);
            $qb->andWhere('u.deptId = :id')->setParameter(':id', $deptId);
        }
        if (!empty($dto->searchKey)) {
            $qb->andWhere('u.userName = :name')->setParameter(':name', $dto->searchKey);
        }

        $qb->setMaxResults($dto->pageSize)->setFirstResult($offset);
        return new Paginator($qb, false);
    }

    /**
     * @throws Exception
     */
    public function deleteUser(int $id)
    {
        $this->_em->beginTransaction();
        try {
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminUser::class, 'u')
                ->where('u.id = :id')->setParameter(':id', $id)
                ->getQuery()->execute();
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminUserRoles::class, 'aur')
                ->where('aur.userId = :id')->setParameter(':id', $id)
                ->getQuery()->execute();
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw $exception;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addUser(UserTableStructRequestDto $dto)
    {
        $this->_em->beginTransaction();
        try {
            $user = new AdminUser();
            $this->assignmentProcessing($user, $dto);
            $this->_em->persist($user);
            $this->_em->flush();
            $this->addUserRole($user, $dto->roleIds);
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw $exception;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateUser(UserTableStructRequestDto $dto)
    {
        $user = $this->find($dto->id);
        if (empty($user)) {
            return;
        }
        $this->_em->beginTransaction();
        try {
            $this->assignmentProcessing($user, $dto);
            $this->deleteUserRoles($user);
            $this->addUserRole($user, $dto->roleIds);
            $this->_em->persist($user);
            $this->_em->flush();
            $this->_em->commit();
        } catch (Exception $exception) {
            $this->_em->rollback();
            throw $exception;
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addUserRole(AdminUser $user, array $roleIds)
    {
        if (empty($roleIds)) {
            return;
        }
        foreach ($roleIds as $roleId) {
            $userRole = new AdminUserRoles();
            $userRole->setUserId($user->getId());
            $userRole->setRoleId((int)$roleId);
            $this->_em->persist($userRole);
        }
        $this->_em->flush();
    }

    public function deleteUserRoles(AdminUser $user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->delete(AdminUserRoles::class, 'aur')
            ->where('aur.userId = :id')
            ->setParameter(':id', $user->getId())
            ->getQuery()
            ->execute();
    }

    private function assignmentProcessing(AdminUser $user, UserTableStructRequestDto $dto)
    {
        if (!is_null($dto->password)) {
            $user->setPassword(PasswordSafeUtils::generate($dto->password));
        }
        if (!is_null($dto->userName)) {
            $user->setUserName($dto->userName);
        }
        $user->setDeptPath($dto->deptPath);
        $user->setDeptId(empty($this->parsePathIdTask->run($dto->deptPath)) ? 0 : $this->parsePathIdTask->run($dto->deptPath));
        $user->setRealName($dto->realName);
        $user->setPhone($dto->phone);
        $user->setIsAdmin($dto->isAdmin);
        $user->setState($dto->state);
        $user->setHomePath($dto->homePath);
    }

    /**
     * @param AdminUser $user
     * @param AdminRole[] $roles
     * @return AdminMenu[]
     */
    public function getUserDetailMenus(AdminUser $user, array $roles): array
    {
        $roleIds = array_column($roles, 'id');

        $qb = $this->_em->createQueryBuilder();
        $qb->select('am')
            ->from(AdminMenu::class, 'am')
            ->leftJoin(AdminRoleMenus::class, 'arm', Join::WITH, 'arm.menuId = am.id')
            ->where($qb->expr()->in('arm.roleId', $roleIds))
            ->andWhere('am.status = 1')
            ->orderBy('am.menuSort', 'ASC')
            ->orderBy('am.createdTime', 'ASC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function chargePwd(AdminUser $user, string $newPwd)
    {
        $pwd = PasswordSafeUtils::generate($newPwd);
        $user->setPassword($pwd);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
