<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Rent;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

final class RentAddOnsDto
{
    public function __construct(
        private bool $transport = false,
        private bool $cleaning = false,
        private bool $installation = false
    ) {
    }

    public static function fromEntity(Rent $rent): self
    {
        return new self(
            $rent->isTransport(),
            $rent->isCleaning(),
            $rent->isInstallation()
        );
    }

    #[Assert\NotBlank]
    #[Assert\Type(Types::BOOLEAN)]
    public function getTransport(): bool
    {
        return $this->transport;
    }

    #[Assert\NotBlank()]
    #[Assert\Type('bool')]
    public function getCleaning(): bool
    {
        return $this->cleaning;
    }

    #[Assert\NotBlank]
    #[Assert\Type('bool')]
    public function getInstallation(): bool
    {
        return $this->installation;
    }
}
