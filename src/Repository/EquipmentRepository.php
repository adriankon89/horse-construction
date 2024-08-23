<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Enum\EquipmentStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipment>
 */
class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    public function save(Equipment $equipment): void
    {
        $this->getEntityManager()->persist($equipment);
        $this->getEntityManager()->flush();
    }

    public function isCurrentlyRented(Equipment $equipment): bool
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.rents', 'r')
            ->where('e.id = :equipmentId')
            ->andWhere('e.status = :equipmentStatus')
            ->andWhere('r.endRateDate > CURRENT_DATE()')
            ->setParameter('equipmentId', $equipment->getId())
            ->setParameter('equipmentStatus', EquipmentStatus::PUBLISHED->value);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result !== null;
    }

    //    /**
    //     * @return Equipment[] Returns an array of Equipment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Equipment
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
