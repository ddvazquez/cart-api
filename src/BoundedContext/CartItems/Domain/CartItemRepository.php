<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Domain;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;

interface CartItemRepository
{
    /**
     * @param  CartItem  $cartItem
     * @return void
     */
    public function save(CartItem $cartItem): void;

    /**
     * @param CartItemId $id
     * @return void
     */
    public function delete(CartItemId $id): void;

    /**
     * @param CartItemId $id
     * @return CartItem|null
     */
    public function search(CartItemId $id): ?CartItem;

    /**
     * @param CartId $cartId
     * @return array
     */
    public function searchByCartId(CartId $cartId) : array;

    /**
     * @param  string  $id
     * @return bool|null
     */
    public function isIdUnique(string $id): ?bool;


}
