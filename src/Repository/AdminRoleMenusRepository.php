<?php

namespace App\Repository;

use App\Entity\AdminRoleMenus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminRoleMenus|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminRoleMenus|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminRoleMenus[]    findAll()
 * @method AdminRoleMenus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRoleMenusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminRoleMenus::class);
    }

    // /**
    //  * @return AdminRoleMenus[] Returns an array of AdminRoleMenus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminRoleMenus
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
