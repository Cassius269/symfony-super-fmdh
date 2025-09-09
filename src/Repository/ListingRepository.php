<?php

namespace App\Repository;

use App\Entity\Listing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Listing>
 */
class ListingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listing::class);
    }

//    /**
//     * @return Listing[] Returns an array of Listing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Listing
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // Fonction de recherche d'appartements
    public function findByPropertyType(string $propertyType){
        return $this->createQueryBuilder('l')
        ->innerJoin('l.propertyType', 'pt')
        ->Where('pt.name = :propertyType')
        ->setParameter('propertyType', $propertyType)
        ->getQuery()
        ->getResult();
    }
}
