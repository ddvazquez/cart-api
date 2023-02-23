<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Tests\Shared\Domain\UuidMother;

final class CartItemIdMother
{
    public static function create(string $value): CartItemId
    {
        return new CartItemId($value);
    }

    public static function creator(): callable
    {
        return static function () {
            return self::random();
        };
    }

    public static function random(): CartItemId
    {
        return self::create(UuidMother::random());
    }
}
