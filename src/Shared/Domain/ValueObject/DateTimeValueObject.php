<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\ValueObject;

abstract class DateTimeValueObject
{
    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }
}
