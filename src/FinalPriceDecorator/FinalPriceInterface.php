<?php

declare(strict_types=1);

namespace App\FinalPriceDecorator;

use App\Entity\Rent;

interface FinalPriceInterface
{
    public function calculateFinalPrice(): int;
    public function getRent(): Rent;
}
