<?php

declare(strict_types=1);

namespace App\Test\Unit\Equipment;

use App\Entity\Equipment;
use App\Enum\EquipmentStatus;
use App\Exception\CannotPublishEquipmentException;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EquipmentTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    private $entityManager;


    protected function setUp(): void
    {

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function test_draft_status_on_create()
    {
        $equipment = new Equipment();
        $equipment->setName('test');
        $repository = $this->entityManager->getRepository(Equipment::class);
        $repository->save($equipment);

        $this->assertSame(EquipmentStatus::DRAFT->value, $equipment->getStatus()->value);
    }

    public function test_publish_if_status_is_not_draft()
    {
        $equipment = new Equipment();
        $equipment->setName('test');
        $equipment->setStatus(EquipmentStatus::REPAIR);

        $this->expectException(CannotPublishEquipmentException::class);

        $equipment->publish();
    }
}
