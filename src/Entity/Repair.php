<?php

namespace App\Entity;

use App\Repository\RepairRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: RepairRepository::class)]
//#[UniqueEntity(fields: ['equipment', 'startRepairDate'])]
#[ORM\HasLifecycleCallbacks]
class Repair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity:Equipment::class, inversedBy: 'repairs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Equipment $equipment = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startRepairDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endRepairDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $actualRepairDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
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
        return $this->startRepairDate;
    }

    public function setStartRepairDate(\DateTimeInterface $startRepairDate): static
    {
        $this->startRepairDate = $startRepairDate;

        return $this;
    }

    public function getEndRepairDate(): ?\DateTimeInterface
    {
        return $this->endRepairDate;
    }

    public function setEndRepairDate(?\DateTimeInterface $endRepairDate): static
    {
        $this->endRepairDate = $endRepairDate;

        return $this;
    }

    public function getActualRepairDate(): ?\DateTimeInterface
    {
        return $this->actualRepairDate;
    }

    public function setActualRepairDate(?\DateTimeInterface $actualRepairDate): static
    {
        $this->actualRepairDate = $actualRepairDate;

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
