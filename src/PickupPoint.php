<?php

declare(strict_types=1);

namespace Omniva;

class PickupPoint
{
    public const int TYPE_TERMINAL = 0;
    public const int TYPE_POST_OFFICE = 1;

    private ?int $type = null;

    public function __construct(private string $identifier)
    {
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setType(int $type): self
    {
        if (! in_array($type, [self::TYPE_TERMINAL, self::TYPE_POST_OFFICE])) {
            throw new \InvalidArgumentException('Unsupported type');
        }

        $this->type = $type;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function isPostOffice(): bool
    {
        $this->guardAgainstEmptyType();

        return $this->getType() === self::TYPE_POST_OFFICE;
    }

    public function isTerminal(): bool
    {
        $this->guardAgainstEmptyType();

        return $this->getType() === self::TYPE_TERMINAL;
    }

    private function guardAgainstEmptyType(): void
    {
        if ($this->getType() === null) {
            throw new \RuntimeException('No type has been provided');
        }
    }
}
