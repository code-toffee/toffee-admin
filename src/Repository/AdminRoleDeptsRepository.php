<?php

namespace App\Repository;

use App\Entity\AdminRoleDepts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminRoleDepts|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminRoleDepts|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminRoleDepts[]    findAll()
 * @method AdminRoleDepts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRoleDeptsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminRoleDepts::class);
    }

    // /**
    //  * @return AdminRoleDepts[] Returns an array of AdminRoleDepts objects
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
    public function findOneBySomeField($value): ?AdminRoleDepts
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
