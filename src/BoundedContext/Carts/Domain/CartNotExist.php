<?php

declare(strict_types = 1);

namespace Spfc\BoundedContext\Carts\Domain;

use Spfc\BoundedContext\Shared\Domain\ValueObjects\CartId;
use Spfc\Shared\Domain\DomainError;

final class CartNotExist extends DomainError
{
    private CartId $id;

    /**
     * @param CartId $id
     */
    public function __construct(CartId $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function errorCode(): string
    {
        return 'cart_not_exist';
    }

    /**
     * @return string
     */
    protected function errorMessage(): string
    {
        return sprintf('The cart <%s> does not exist', $this->id->value());
    }
}
