<?php

namespace App\Factory\Rent;

class DecoratorRegistry
{
    private array $decorators = [];

    public function __construct(iterable $decoratorIds)
    {
        foreach ($decoratorIds as $decorator) {
            $this->decorators[] = $decorator;
        }
    }

    public function registerDecorator(string $key, string $decoratorClass): void
    {
        $this->decorators[$key] = $decoratorClass;
    }

    public function getDecorator(string $key): ?string
    {
        return $this->decorators[$key] ?? null;
    }

    public function getAll(): array
    {
        return $this->decorators;
    }
}
