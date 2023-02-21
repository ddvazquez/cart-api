<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Domain;

use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;

interface CartRepository
{
    /**
     * @param  Cart  $cart
     * @return void
     */
    public function save(Cart $cart): void;

    /**
     * @param CartId $id
     * @return Cart|null
     */
    public function search(CartId $id): ?Cart;

    /**
     * @param  string  $id
     * @return bool|null
     */
    public function isIdUnique(string $id): ?bool;
}
