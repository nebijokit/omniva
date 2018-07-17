<?php

namespace Omniva;

class PickupPoint
{
    const TYPE_TERMINAL = 0;
    const TYPE_POST_OFFICE = 1;

    private $type;
    private $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
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
        if (!in_array($type, [self::TYPE_TERMINAL, self::TYPE_POST_OFFICE])) {
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
