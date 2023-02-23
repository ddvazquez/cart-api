<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Application\Create\CartItemCreator;
use Spfc\Shop\CartItems\Application\Create\CreateCartItemRequest;
use Spfc\Shop\CartItems\Domain\CartItem;
use Spfc\Shop\CartItems\Domain\CartItemDescription;
use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Shop\CartItems\Domain\CartItemPrice;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;

use Spfc\Tests\Shop\Shared\Domain\CartIdMother;

use Spfc\Tests\Shop\Shared\Domain\ProductIdMother;

final class CartItemMother
{
    public static function create(CartItemId $id, CartId $cartId, ProductId $productId, CartItemName $name, CartItemDescription $description, CartItemPrice $price): CartItem
    {
        return CartItem::create($id, $cartId, $productId, $name,  $description,  $price,  true);
    }

    public static function fromRequest(CreateCartItemRequest $request): CartItem
    {
        return self::create(
            new CartItemId($request->id()),
            new CartId($request->cartId()),
            new ProductId($request->productId()),
            new CartItemName($request->name()),
            new CartItemDescription($request->description()),
            new CartItemPrice($request->price()),
        );
    }

    public static function random(): CartItem
    {
        return self::create(CartItemIdMother::random(), CartIdMother::random(), ProductIdMother::random(), CartItemNameMother::random(), CartItemDescriptionMother::random(), CartItemPriceMother::random());
    }
}
