<?php

declare(strict_types = 1);

namespace Spfc\BoundedContext\CartItems\Domain;

use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;
use Spfc\Shared\Domain\DomainError;

final class CartItemNotExist extends DomainError
{
    private CartItemId $id;

    /**
     * @param CartItemId $id
     */
    public function __construct(CartItemId $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function errorCode(): string
    {
        return 'cart_item_not_exist';
    }

    /**
     * @return string
     */
    protected function errorMessage(): string
    {
        return sprintf('The cart item <%s> does not exist', $this->id->value());
    }
}
