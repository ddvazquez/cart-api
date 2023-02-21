<?php

declare(strict_types = 1);

namespace Spfc\Shop\Carts\Application\Update;


use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Domain\CartRepository;

final class CartTotalsDecrementer
{
    private CartRepository $repository;
    private CartFinder $finder;

    /**
     * @param CartRepository $repository
     * @param CartFinder $cartFinder
     */
    public function __construct(CartRepository $repository, CartFinder $cartFinder) {
        $this->repository    = $repository;
        $this->finder     = $cartFinder;
    }

    /**
     * @param string $id
     * @param float $price
     * @return void
     */
    public function __invoke(string $id,  float $price)
    {
        $cart = $this->finder->__invoke($id);

        $cart->totalsDecrement($price);

        $this->repository->save($cart);
    }
}
