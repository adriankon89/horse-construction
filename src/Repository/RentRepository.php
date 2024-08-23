<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\Rent;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rent>
 */
class RentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rent::class);
    }


    public function hasOverlappingRent(Equipment $equipment, DateTime $startRentDate, DateTime $endRentDate): ?Rent
    {
        return $this->createQueryBuilder("r")
        ->where('r.equipment = :equipment')
        ->andWhere('r.startRentDate < :endRentDate')
        ->andWhere('r.endRentDate > :startRentDate')
        ->setParameters(new ArrayCollection([
            new Parameter('equipment', $equipment),
            new Parameter('endRentDate', $endRentDate),
            new Parameter('startRentDate', $startRentDate),

        ]))
        ->getQuery()
        ->getOneOrNullResult();

    }

    //    /**
    //     * @return Rent[] Returns an array of Rent objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Rent
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
