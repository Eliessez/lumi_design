<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    public function paginateProduct(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('p'),$page,10);
    }
    public function paginateProductOrderByUpdatedAt(int $page): PaginationInterface
    {
        return $this->paginator->paginate($this->createQueryBuilder('p')->orderBy('p.updatedAt', 'DESC'), $page, 10);
    }

    public function findOneWithCategory($slug): ?Product
    {
        return $this->createQueryBuilder('p')
        ->leftJoin('p.category', 'c')
        ->andWhere('p.slug = :slug')
        ->setParameter('slug', $slug)
        ->getQuery()
        ->getOneOrNullResult();
    }
}

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
