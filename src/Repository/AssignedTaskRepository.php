<?php

namespace App\Repository;

use App\Entity\AssignedTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssignedTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignedTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignedTask[]    findAll()
 * @method AssignedTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignedTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignedTask::class);
    }

    // /**
    //  * @return AssignedTask[] Returns an array of AssignedTask objects
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
    public function findOneBySomeField($value): ?AssignedTask
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
