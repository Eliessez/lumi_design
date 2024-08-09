<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    //    /**
    //     * @return Orders[] Returns an array of Orders objects
    //     */
       public function findByOrdersWithRelations($value): array
       {
           return $this->createQueryBuilder('o')
           ->leftJoin('o.orderItems', 'oi')
           ->leftJoin('oi.product', 'p')
           ->where('o.id = :id')
           ->setParameter(':id', $value)
           ->getQuery()
           ->getOneOrNullResult();
       }

    //    public function findOneBySomeField($value): ?Orders
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
