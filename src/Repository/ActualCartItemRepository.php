<?php

namespace App\Repository;

use App\Entity\ActualCartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActualCartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualCartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualCartItem[]    findAll()
 * @method ActualCartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualCartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualCartItem::class);
    }

    public function deleteAll(){
        $query = $this->createQueryBuilder('e')
                 ->delete()
                 ->getQuery()
                 ->execute();
        return $query;
}

    // /**
    //  * @return ActualCartItem[] Returns an array of ActualCartItem objects
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
    public function findOneBySomeField($value): ?ActualCartItem
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
