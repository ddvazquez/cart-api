<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Application\Create;

use Illuminate\Http\Request;
use Spfc\Shop\CartItems\Application\Create\CreateCartItemRequest;
use Spfc\Tests\Shop\CartItems\Domain\CartItemDescriptionMother;
use Spfc\Tests\Shop\CartItems\Domain\CartItemIdMother;
use Spfc\Tests\Shop\CartItems\Domain\CartItemNameMother;
use Spfc\Tests\Shop\CartItems\Domain\CartItemPriceMother;
use Spfc\Tests\Shop\Shared\Domain\CartIdMother;
use Spfc\Tests\Shop\Shared\Domain\ProductIdMother;

final class CreateCartItemRequestMother
{
    /**
     * @param string $id
     * @param string $cartId
     * @param Request $request
     * @return CreateCartItemRequest
     */
    public static function create(string $id, string $cartId, Request $request): CreateCartItemRequest
    {
        return new CreateCartItemRequest($id, $cartId, $request);
    }

    /**
     * @return CreateCartItemRequest
     */
    public static function random(): CreateCartItemRequest
    {
        $request = new Request();

        $request->merge([
            'productId' => ProductIdMother::random()->value(),
            'name' => CartItemNameMother::random()->value(),
            'description' => CartItemDescriptionMother::random()->value(),
            'price' => CartItemPriceMother::random()->value()
        ]);

        return self::create(CartItemIdMother::random()->value(), CartIdMother::random()->value(),$request);
    }
}
