<?php

namespace App\Repository;

use App\Entity\WaitingOrderCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WaitingOrderCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method WaitingOrderCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method WaitingOrderCart[]    findAll()
 * @method WaitingOrderCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WaitingOrderCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WaitingOrderCart::class);
    }

    public function deleteAll(){
        $query = $this->createQueryBuilder('e')
                 ->delete()
                 ->getQuery()
                 ->execute();
        return $query;
}

    // /**
    //  * @return WaitingOrderCart[] Returns an array of WaitingOrderCart objects
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
    public function findOneBySomeField($value): ?WaitingOrderCart
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
