<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Domain;

interface CartItemRepository
{
    /**
     * @param  CartItem  $cartItem
     * @return void
     */
    public function save(CartItem $cartItem): void;

    /**
     * @param  string  $id
     * @return bool|null
     */
    public function isIdUnique(string $id): ?bool;
}
