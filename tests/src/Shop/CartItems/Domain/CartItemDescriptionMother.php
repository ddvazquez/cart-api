<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Domain\CartItemDescription;
use Spfc\Tests\Shared\Domain\WordMother;

final class CartItemDescriptionMother
{
    public static function create(string $value): CartItemDescription
    {
        return new CartItemDescription($value);
    }

    public static function random(): CartItemDescription
    {
        return self::create(WordMother::random());
    }
}
