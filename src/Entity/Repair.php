<?php

namespace App\Entity;

use App\Repository\RepairRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: RepairRepository::class)]
//#[UniqueEntity(fields: ['equipment', 'start_repair_date'])]
#[ORM\HasLifecycleCallbacks]
class Repair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'start_repair_date')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Equipment $equipment = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_repair_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_repair_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $actual_repair_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getStartRepairDate(): ?\DateTimeInterface
    {
        return $this->start_repair_date;
    }

    public function setStartRepairDate(\DateTimeInterface $start_repair_date): static
    {
        $this->start_repair_date = $start_repair_date;

        return $this;
    }

    public function getEndRepairDate(): ?\DateTimeInterface
    {
        return $this->end_repair_date;
    }

    public function setEndRepairDate(?\DateTimeInterface $end_repair_date): static
    {
        $this->end_repair_date = $end_repair_date;

        return $this;
    }

    public function getActualRepairDate(): ?\DateTimeInterface
    {
        return $this->actual_repair_date;
    }

    public function setActualRepairDate(?\DateTimeInterface $actual_repair_date): static
    {
        $this->actual_repair_date = $actual_repair_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    #[Assert\Callback]
    public function isEquipmentAvailable(ExecutionContextInterface $context)
    {
        /*
        if(null === $this->getId()) {
            $context->buildViolation('Equipment is currently under repair')
            ->addViolation();
        }
            */

    }

}
