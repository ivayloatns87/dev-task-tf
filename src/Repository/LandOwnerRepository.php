<?php

namespace App\Repository;

use App\Entity\LandOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LandOwnerRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method LandOwnerRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method LandOwnerRepository[]    findAll()
 * @method LandOwnerRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LandOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LandOwnerRepository::class);
    }

    // /**
    //  * @return LandOwnerRepository[] Returns an array of LandOwnerRepository objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LandOwnerRepository
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
