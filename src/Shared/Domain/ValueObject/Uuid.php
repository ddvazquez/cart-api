<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\ValueObject;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Uuid
{
    private string $value;

    /**
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);
        $this->value = $value;
    }

    /**
     * @return Uuid
     */
    public static function random(): self
    {
        return new self(Str::uuid()->toString());
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param $id
     * @return void
     */
    private function ensureIsValidUuid(string $id): void
    {
        if (! Str::isUuid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }
}
