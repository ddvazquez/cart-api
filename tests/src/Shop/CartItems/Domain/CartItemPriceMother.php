<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Shop\CartItems\Domain\CartItemPrice;
use Spfc\Tests\Shared\Domain\FloatMother;
use Spfc\Tests\Shared\Domain\WordMother;

final class CartItemPriceMother
{
    public static function create(float $value): CartItemPrice
    {
        return new CartItemPrice($value);
    }

    public static function random(): CartItemPrice
    {
        return self::create(FloatMother::between(2, 1, 100));
    }
}
