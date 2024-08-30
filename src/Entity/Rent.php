<?php

namespace App\Entity;

use App\EventListener\RentValidationListener;
use App\Repository\RentRepository;
use App\Validator\Constraints as CustomAssert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RentRepository::class)]
#[ORM\EntityListeners([RentValidationListener::class])]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    // #[CustomAssert\DuplicateRent]
    private ?Equipment $equipment = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startRentDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual(propertyPath: 'startRentDate')]
    private ?\DateTimeInterface $endRentDate = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Positive]
    private ?int $price = null;

    #[ORM\Column(nullable: true, type: Types::INTEGER)]
    private ?int $discount = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Positive]
    private ?int $finalPrice = null;

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

    public function getStartRentDate(): ?\DateTimeInterface
    {
        return $this->startRentDate;
    }

    public function setStartRentDate(\DateTimeInterface $startRentDate): static
    {
        $this->startRentDate = $startRentDate;

        return $this;
    }

    public function getendRentDate(): ?\DateTimeInterface
    {
        return $this->endRentDate;
    }

    public function setendRentDate(\DateTimeInterface $endRentDate): static
    {
        $this->endRentDate = $endRentDate;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    //TODO none of type hint
    public function setDiscount($discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFinalPrice(): ?int
    {
        return $this->finalPrice;
    }

    public function setFinalPrice($finalPrice): static
    {
        $this->finalPrice = $finalPrice;

        return $this;
    }

    public function setInitialPrice(): void
    {
        $equipment =  $this->getEquipment();
        if(null === $equipment) {
            throw new \LogicException('Equipment is required to calculate initial price');
        }
        $equipmentPrice = $equipment->getPrice();
        $this->setFinalPrice($equipmentPrice);
        $this->setPrice($equipmentPrice);
    }
}
