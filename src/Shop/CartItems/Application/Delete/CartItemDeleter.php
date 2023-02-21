<?php

declare(strict_types=1);

namespace Spfc\Shop\CartItems\Application\Delete;

use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemNotExist;
use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Application\Update\CartTotalsDecrementer;
use function Lambdish\Phunctional\apply;

final class CartItemDeleter
{
    private CartItemRepository $repository;
    private CartFinder $cartFinder;
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

        if($cart->paid()->value()) {
            throw new \InvalidArgumentException(
                sprintf('<%s> cart is already payed.', $cartItem->cartId()->value())
            );
        }

        $this->repository->delete($id);

        apply($this->cartTotalsDecrementer, [$cartItem->cartId()->value(), $cartItem->price()->value()]);
    }
}
