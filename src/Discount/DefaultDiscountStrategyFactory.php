<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Rent;
use App\Enum\EquipmentDimension;

final class DefaultDiscountStrategyFactory implements DiscountStrategyFactoryInterface
{
    private const LONG_TERM_THRESHOLD_DAYS = 30;
    private Rent $rent;

    public function createStrategy(Rent $rent): ?DiscountStrategyInterface
    {
        $this->rent = $rent;
        if (true === $this->isFirstUserRent()) {
            return new FirstRentDiscount();
        }

        if (true === $this->isLongTermRental()) {
            return new LongTermRentalDiscount();
        }

        if (true == $this->isRentForLargestDimension()) {
            return new LargestDimensionDiscount();
        }

        return null;
    }

    private function isFirstUserRent(): bool
    {
        return $this->rent->getUser()->getRents()->isEmpty();
    }

    private function isLongTermRental(): bool
    {
        $startRentDate = $this->rent->getStartRentDate();
        $endRentDate = $this->rent->getEndRentDate();

        $interval = $startRentDate->diff($endRentDate);
        $amountOfRentDays = $interval->format('%d');

        return $amountOfRentDays > self::LONG_TERM_THRESHOLD_DAYS;

    }

    private function isRentForLargestDimension(): bool
    {
        return $this->rent->getEquipment()->getDimension() === EquipmentDimension::C;
    }

}
