<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Domain;

use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Tests\Shared\Domain\UuidMother;

final class CartIdMother
{
    public static function create(string $value): CartId
    {
        return new CartId($value);
    }

    public static function creator(): callable
    {
        return static function () {
            return self::random();
        };
    }

    public static function random(): CartId
    {
        return self::create(UuidMother::random());
    }
}
