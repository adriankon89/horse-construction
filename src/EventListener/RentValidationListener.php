<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Rent;
use App\Exception\EquipmentShouldBeActiveException;
use App\Exception\RentIsOverlapException;
use App\Repository\RentRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist')]
class RentValidationListener
{
    private RentRepository $rentRepository;

    public function __construct(RentRepository $rentRepository)
    {
        $this->rentRepository = $rentRepository;
    }

    public function prePersist(Rent $rent, LifecycleEventArgs $args): void
    {
        $equipment = $rent->getEquipment();

        if (false === $equipment->isActive()) {
            throw new EquipmentShouldBeActiveException('Equipment for renting needs to be active');
        }

        $startRentDate = $rent->getStartRentDate();
        $endRentDate = $rent->getEndRentDate();
        if (null !== $this->rentRepository->hasOverlappingRent($equipment, $startRentDate, $endRentDate)) {
            throw new RentIsOverlapException("The equipment is already rented for the specified period.");
        }
    }
}
