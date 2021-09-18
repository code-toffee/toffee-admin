<?php

namespace App\Repository;

use App\Dto\Admin\Request\MenuStructRequstDto;
use App\Entity\AdminMenu;
use App\Entity\AdminRoleMenus;
use App\Task\Admin\ParsePathIdTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method AdminMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminMenu[]    findAll()
 * @method AdminMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminMenuRepository extends ServiceEntityRepository
{
    private ParsePathIdTask $parsePathIdTask;

    public function __construct(ManagerRegistry $registry, ParsePathIdTask $parsePathIdTask)
    {
        parent::__construct($registry, AdminMenu::class);
        $this->parsePathIdTask = $parsePathIdTask;
    }

    public function deleteMenu(array $ids)
    {
        $this->_em->beginTransaction();
        try {
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminMenu::class, 'd')
                ->where($qb->expr()->in('d.id', ':ids'))
                ->setParameter(':ids', $ids);
            $qb->getQuery()->execute();

            $qb = $this->_em->createQueryBuilder();
            $qb->delete(AdminRoleMenus::class, 'arm')
                ->where($qb->expr()->in('arm.menuId', ':ids'))
                ->setParameter(':ids', $ids);
            $qb->getQuery()->execute();
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
    public function addMenu(MenuStructRequstDto $dto)
    {
        $menu = new AdminMenu();
        $this->assignmentProcessing($menu, $dto);
        $this->_em->persist($menu);
        $this->_em->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateMenu(MenuStructRequstDto $dto)
    {
        $id = $this->parsePathIdTask->run($dto->id);

        $menu = $this->find($id);
        if (empty($menu)) {
            return;
        }
        $this->assignmentProcessing($menu, $dto);
        $this->_em->persist($menu);
        $this->_em->flush();
    }

    private function assignmentProcessing(AdminMenu $menu, MenuStructRequstDto $dto)
    {
        $pid = $this->parsePathIdTask->run($dto->pid);
        $menu->setTitle($dto->title);
        $menu->setType($dto->type);
        $menu->setPath($dto->path);
        $menu->setRedirect($dto->redirect);
        $menu->setPid((int)$pid);
        $menu->setStatus($dto->status);
        $menu->setComponent($dto->component);
        $menu->setName($dto->name);
        $menu->setMenuSort($dto->orderNo);
        $menu->setIcon($dto->icon);
        $menu->setPermission($dto->permission);
        $menu->setIFrame($dto->iFrame);
        $menu->setFramePath($dto->framePath);
        $menu->setCache($dto->cache);
        $menu->setHideMenu($dto->hideMenu);
    }
}
