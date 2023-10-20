<?php

namespace App\Repository;

use App\Entity\TaskShare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskShare>
 *
 * @method TaskShare|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskShare|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskShare[]    findAll()
 * @method TaskShare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskShareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskShare::class);
    }

//    /**
//     * @return TaskShare[] Returns an array of TaskShare objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaskShare
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
