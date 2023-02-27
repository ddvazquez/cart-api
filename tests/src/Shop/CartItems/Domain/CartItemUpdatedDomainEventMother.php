<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Domain;

use Spfc\Shop\CartItems\Domain\CartItem;
use Spfc\Shop\CartItems\Domain\CartItemDescription;
use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Shop\CartItems\Domain\CartItemPrice;
use Spfc\Shop\CartItems\Domain\CartItemUpdatedDomainEvent;

use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;
use Spfc\Tests\Shop\Shared\Domain\CartIdMother;
use Spfc\Tests\Shop\Shared\Domain\ProductIdMother;

final class CartItemUpdatedDomainEventMother
{
    /**
     * @param CartItemId $id
     * @param CartId $cartId
     * @param ProductId $productId
     * @param CartItemName $name
     * @param CartItemDescription $description
     * @param CartItemPrice $price
     * @return CartItemUpdatedDomainEvent
     */
    public static function create(CartItemId $id, CartId $cartId, ProductId $productId, CartItemName $name, CartItemDescription $description, CartItemPrice $price): CartItemUpdatedDomainEvent
    {
        return new CartItemUpdatedDomainEvent($id->value(), $cartId->value(), $productId->value(), $name->value(), $description->value(), $price->__toString());
    }

    /**
     * @param CartItem $cartItem
     * @return CartItemUpdatedDomainEvent
     */
    public static function fromCartIte(CartItem $cartItem): CartItemUpdatedDomainEvent
    {
        return self::create($cartItem->id(), $cartItem->cartId(), $cartItem->productId(), $cartItem->name(), $cartItem->description(), $cartItem->price());
    }

    /**
     * @return CartItemUpdatedDomainEvent
     */
    public static function random(): CartItemUpdatedDomainEvent
    {
        return self::create(CartItemIdMother::random(), CartIdMother::random(), ProductIdMother::random(), CartItemNameMother::random(), CartItemDescriptionMother::random(), CartItemPriceMother::random());
    }
}
