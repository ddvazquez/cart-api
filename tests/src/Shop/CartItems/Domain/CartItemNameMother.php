<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Tests\Shared\Domain\WordMother;

final class CartItemNameMother
{
    public static function create(string $value): CartItemName
    {
        return new CartItemName($value);
    }

    public static function random(): CartItemName
    {
        return self::create(WordMother::random());
    }
}
