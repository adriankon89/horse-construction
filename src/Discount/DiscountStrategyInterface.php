<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Rent;

interface DiscountStrategyInterface
{
    public function calculate(Rent $rent): void;

    public function handle(Rent $rent): void;

    public function supports(Rent $rent): bool;
}
