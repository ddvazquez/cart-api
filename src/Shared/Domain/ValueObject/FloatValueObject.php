<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    protected float $value;

    /**
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}
