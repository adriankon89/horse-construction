<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Enum\EquipmentDimension;
use App\Enum\EquipmentStatus;
use App\Enum\EquipmentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class EquipmentFixtures extends Fixture
{
    private $faker;
    private $manager;
    public function __construct(

    ) {
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->createDraftEquipment();
        $this->createPublishEquipment();
        $this->manager->flush();
    }

    private function createDraftEquipment(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $equipment = new Equipment();
            $equipment->setName($this->faker->word());
            $equipment->setPrice($this->faker->randomNumber(3, true));
            $equipment->setDimension(EquipmentDimension::A);
            $equipment->setType(EquipmentType::Drill);
            $this->manager->persist($equipment);

        }

    }

    private function createPublishEquipment(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $equipment = new Equipment();
            $equipment->setName($this->faker->word());
            $equipment->setPrice($this->faker->randomNumber(3, true));
            $equipment->setDimension(EquipmentDimension::A);
            $equipment->setType(EquipmentType::Dehumidifier);
            $equipment->setStatus(EquipmentStatus::PUBLISHED);
            $this->manager->persist($equipment);
            //TODO setStatus should be private or removed? I should change a status only by some bussines action
            $equipment->setStatus(EquipmentStatus::PUBLISHED);

        }
    }
}
