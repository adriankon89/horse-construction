<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Equipment;
use App\Entity\Repair;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;

//#[AsEntityListener(event: Events::prePersist, entity: Repair::class)]
final class RepairListener
{
    public function prePersist(Repair $repair, PostUpdateEventArgs $event): void
    {
        $repair = $event->getObject();
        if (!$repair instanceof Repair) {
            return;
        }
        $equipment = $repair->getEquipment();
        if (false === empty($equipment)) {
            return;
        }
        $equipment->repair();
        //set all orders as ended

        // ... do something to notify the changes
    }
}
