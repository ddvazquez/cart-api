<?php

declare(strict_types=1);

namespace Spfc\Shop\CartItems\Domain;

use Spfc\BoundedContext\Users\Domain\UserCreatedDomainEvent;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;
use Spfc\Shared\Domain\Aggregate\AggregateRoot;

final class CartItem extends AggregateRoot
{
    private CartItemId $id;
    private CartId $cartId;
    private ProductId $productId;
    private CartItemName $name;
    private CartItemDescription $description;
    private CartItemPrice $price;

    /**
     * @param CartItemId $id
     * @param CartId $cartId
     * @param ProductId $productId
     * @param CartItemName $name
     * @param CartItemDescription $description
     * @param CartItemPrice $price
     */
    public function __construct(CartItemId $id, CartId $cartId, ProductId $productId, CartItemName $name, CartItemDescription $description, CartItemPrice $price)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * @param CartItemId $id
     * @param CartId $cartId
     * @param ProductId $productId
     * @param CartItemName $name
     * @param CartItemDescription $description
     * @param CartItemPrice $price
     * @param bool $isIdUnique
     * @return static
     */
    public static function create(CartItemId $id, CartId $cartId, ProductId $productId, CartItemName $name, CartItemDescription $description, CartItemPrice $price, bool $isIdUnique): self
    {
        if (! $isIdUnique) {
            throw new \InvalidArgumentException(
                sprintf('<%s> id already exists.', $id->value())
            );
        }

        $cartItem = new self($id, $cartId, $productId, $name, $description, $price);

        $cartItem->record(new CartItemUpdatedDomainEvent($id->value(), $cartId->value(), $productId->value(), $name->value(), $description->value(), $price->__toString()));

        return $cartItem;
    }

    /**
     * @return $this
     */
    public function delete(): void
    {
        $this->record(new CartItemUpdatedDomainEvent( $this->id->value(),  $this->cartId->value(),  $this->productId->value(),  $this->name->value(),  $this->description->value(),  $this->price->__toString()));
    }

    /**
     * @return CartItemId
     */
    public function id(): CartItemId
    {
        return $this->id;
    }

    /**
     * @return CartId
     */
    public function cartId(): CartId
    {
        return $this->cartId;
    }


    /**
     * @return ProductId
     */
    public function productId(): ProductId
    {
        return $this->productId;
    }


    /**
     * @return CartItemName
     */
    public function name(): CartItemName
    {
        return $this->name;
    }

    /**
     * @return CartItemDescription
     */
    public function description(): CartItemDescription
    {
        return $this->description;
    }

    /**
     * @return CartItemPrice
     */
    public function price(): CartItemPrice
    {
        return $this->price;
    }
}
