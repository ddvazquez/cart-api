<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    protected $value;

    /**
     * @param  int  $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
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
