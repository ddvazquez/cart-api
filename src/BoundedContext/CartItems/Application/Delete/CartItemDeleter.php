<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Delete;


use Spfc\BoundedContext\CartItems\Domain\CartItemId;
use Spfc\BoundedContext\CartItems\Domain\CartItemNotExist;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\Carts\Application\Update\CartTotalsDecrementer;
use function Lambdish\Phunctional\apply;

final class CartItemDeleter
{
    private CartItemRepository $repository;
    private CartTotalsDecrementer $cartTotalsDecrementer;

    /**
     * @param CartItemRepository $repository
     * @param CartTotalsDecrementer $cartTotalsDecrementer
     */
    public function __construct(CartItemRepository $repository, CartTotalsDecrementer $cartTotalsDecrementer)
    {
        $this->repository = $repository;
        $this->cartTotalsDecrementer = $cartTotalsDecrementer;
    }

    /**
     * @param string $id
     * @return void
     */
    public function __invoke(string $id)
    {
        $id = new CartItemId($id);

        $cartItem = $this->repository->search($id);

        if (null === $cartItem) {
            throw new CartItemNotExist($id);
        }

        $this->repository->delete($id);

        apply($this->cartTotalsDecrementer, [$cartItem->cartId(), $cartItem->price()->value()]);
    }
}
