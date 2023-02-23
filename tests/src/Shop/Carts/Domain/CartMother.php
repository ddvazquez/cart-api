<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Domain;

use Spfc\Shop\Carts\Domain\Cart;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;

final class CartMother
{
    public static function create(CartId $id): Cart
    {
        return Cart::create($id, true);
    }

    public static function random(): Cart
    {
        return self::create(CartIdMother::random());
    }
}
