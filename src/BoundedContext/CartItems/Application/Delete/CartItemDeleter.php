<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Delete;


use Spfc\BoundedContext\CartItems\Domain\CartItemId;
use Spfc\BoundedContext\CartItems\Domain\CartItemNotExist;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\Carts\Application\Find\CartFinder;
use Spfc\BoundedContext\Carts\Application\Update\CartTotalsDecrementer;
use function Lambdish\Phunctional\apply;

final class CartItemDeleter
{
    private CartItemRepository $repository;
    private CartTotalsDecrementer $cartTotalsDecrementer;

    /**
     * @param CartItemRepository $repository
     * @param CartFinder $cartFinder
     * @param CartTotalsDecrementer $cartTotalsDecrementer
     */
    public function __construct(CartItemRepository $repository, CartFinder $cartFinder, CartTotalsDecrementer $cartTotalsDecrementer)
    {
        $this->repository = $repository;
        $this->cartFinder = $cartFinder;
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

        $cart = $this->cartFinder->__invoke($cartItem->cartId()->value());

        if($cart->payed()->value()) {
            throw new \InvalidArgumentException(
                sprintf('<%s> cart is already payed.', $cartItem->cartId())
            );
        }

        $this->repository->delete($id);

        apply($this->cartTotalsDecrementer, [$cartItem->cartId()->value(), $cartItem->price()->value()]);
    }
}
