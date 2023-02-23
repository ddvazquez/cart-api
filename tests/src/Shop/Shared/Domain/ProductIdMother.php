<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Shared\Domain;

use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;
use Spfc\Tests\Shared\Domain\UuidMother;

final class ProductIdMother
{
    public static function create(string $value): ProductId
    {
        return new ProductId($value);
    }

    public static function creator(): callable
    {
        return static function () {
            return self::random();
        };
    }

    public static function random(): ProductId
    {
        return self::create(UuidMother::random());
    }
}
