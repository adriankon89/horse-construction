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
        ->andWhere(
            $this->createQueryBuilder('r')
                ->expr()->orX(
                    $this->createQueryBuilder('r')
                        ->expr()->andX(
                            'r.startRentDate < :endRentDate',
                            'r.endRentDate > :startRentDate'
                        ),
                    $this->createQueryBuilder('r')
                        ->expr()->andX(
                            'r.startRentDate <= :startRentDate',
                            'r.endRentDate >= :endRentDate'
                        )
                )
        )
        ->setParameters(new ArrayCollection([
            new Parameter('equipment', $equipment),
            new Parameter('endRentDate', $endRentDate),
            new Parameter('startRentDate', $startRentDate),
        ]))
        ->getQuery()
        ->setMaxResults(1)
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
