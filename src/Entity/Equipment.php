<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EquipmentDimension;
use App\Enum\EquipmentStatus;
use App\Enum\EquipmentType;
use App\Exception\CannotPublishEquipmentException;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
//#[UniqueEntity('name', message: 'This name is already used')]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 50, options: ['default' => EquipmentStatus::DRAFT])]
    private ?EquipmentStatus $status = EquipmentStatus::DRAFT;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?EquipmentDimension $dimension = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?EquipmentType $type = null;

    #[ORM\Column(length: 255, nullable: true, type: Types::STRING)]
    private ?string $img = null;

    /**
     * @var Collection<int, Repair>
     */
    #[ORM\OneToMany(targetEntity: Repair::class, mappedBy: 'equipment')]
    private Collection $repairs;

    /**
     * @var Collection<int, Rent>
     */
    #[ORM\OneToMany(targetEntity: Rent::class, mappedBy: 'equipment')]
    private Collection $rents;

    public function __construct()
    {
        $this->repairs = new ArrayCollection();
        $this->rents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?EquipmentStatus
    {
        return $this->status;
    }

    public function setStatus(EquipmentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDimension(): ?EquipmentDimension
    {
        return $this->dimension;
    }

    public function setDimension(?EquipmentDimension $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getType(): ?EquipmentType
    {
        return $this->type ;
    }

    public function setType(?EquipmentType $type): static
    {
        /**
         *        if(!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE], true)) {
            throw new \InvalidArgumentException('Invalid driver status');
        }
         */
        $this->type = $type;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    #[ORM\PrePersist]
    public function setStatusValue(): void
    {
        $this->setStatus(EquipmentStatus::DRAFT);

    }

    public function canBePublished(): bool
    {
        $hasFilledValues = $this->hasFilledValues();
        $isDraft = $this->getStatus() === EquipmentStatus::DRAFT;

        return $isDraft && $hasFilledValues;
    }

    private function hasFilledValues(): bool
    {
        $properties = get_object_vars($this);
        foreach ($properties as $value) {
            if (is_null($value)) {
                return false;
            }
        }
        return true;
    }

    public function publish(): static
    {
        if(!$this->canBePublished()) {
            throw new CannotPublishEquipmentException(
                sprintf('Cannot publish equipment id: %s', $this->id)
            );
        }
        $this->setStatus(EquipmentStatus::PUBLISHED);
        return $this;

    }


    public function repair(): static
    {
        $this->setStatus(EquipmentStatus::REPAIR);

        return $this;
    }

    /**
     * @return Collection<int, Repair>
     */
    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function addRepair(Repair $repair): static
    {
        if (!$this->repairs->contains($repair)) {
            $this->repairs->add($repair);
            $repair->setEquipment($this);
        }

        return $this;
    }

    public function removeRepair(Repair $repair): static
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getEquipment() === $this) {
                $repair->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rent>
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): static
    {
        if (!$this->rents->contains($rent)) {
            $this->rents->add($rent);
            $rent->setEquipment($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): static
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getEquipment() === $this) {
                $rent->setEquipment(null);
            }
        }

        return $this;
    }

    public function canRepair(): bool
    {
        $rents = $this->getRents();
        if(true === in_array($this->getStatus(), [EquipmentStatus::DRAFT, EquipmentStatus::REPAIR])) {
            dd('status');
            return false;
        }
        $today = new \DateTime();

        foreach ($rents as $rent) {
            dd('rents');
            return false;
        }


        return true;
    }

    public function isActive(): bool
    {
        return $this->getStatus() === EquipmentStatus::PUBLISHED;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
