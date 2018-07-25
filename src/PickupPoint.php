<?php

namespace Omniva;

class PickupPoint
{
    const TYPE_TERMINAL = 0;
    const TYPE_POST_OFFICE = 1;

    private $type;
    private $identifier;

    /**
     * PickupPoint constructor.
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $identifier
     * @return PickupPoint
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param int $type
     * @return PickupPoint
     */
    public function setType($type)
    {
        if (!in_array($type, [self::TYPE_TERMINAL, self::TYPE_POST_OFFICE])) {
            throw new \InvalidArgumentException('Unsupported type');
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isPostOffice()
    {
        $this->guardAgainstEmptyType();
        return $this->getType() === self::TYPE_POST_OFFICE;
    }

    /**
     * @return bool
     */
    public function isTerminal()
    {
        $this->guardAgainstEmptyType();
        return $this->getType() === self::TYPE_TERMINAL;
    }

    private function guardAgainstEmptyType()
    {
        if ($this->getType() === null) {
            throw new \RuntimeException('No type has been provided');
        }
    }
}
