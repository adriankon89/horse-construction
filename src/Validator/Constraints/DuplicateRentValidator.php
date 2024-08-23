<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Entity\Equipment;
use App\Entity\Rent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DuplicateRentValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {

    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (true !== $constraint instanceof DuplicateRent) {
            throw new UnexpectedTypeException($constraint, DuplicateRent::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (true !== $value instanceof Equipment) {
            throw new UnexpectedValueException($value, Equipment::class);
        }

        $equipmentRepository = $this->manager->getRepository(Equipment::class);

        if(true === $equipmentRepository->isCurrentlyRented($value)) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ equipment }}', $value->getName())
            ->addViolation();
        }
        return;
    }
}
