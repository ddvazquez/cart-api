<?php

declare(strict_types = 1);

namespace Spfc\Shop\Carts\Application\Update;


use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Domain\CartRepository;

final class CartTotalsUpdater
{
    private CartRepository $repository;
    private CartFinder $finder;

    private CartItemsTotalCalculator $cartItemsTotalizator;

    /**
     * @param CartRepository $repository
     * @param CartFinder $cartFinder
     */
    public function __construct(CartRepository $repository, CartFinder $cartFinder, CartItemsTotalCalculator $cartItemsTotalizator) {
        $this->repository    = $repository;
        $this->finder     = $cartFinder;
        $this->cartItemsTotalizator  = $cartItemsTotalizator;
    }

    /**
     * @param string $id
     * @return void
     */
    public function __invoke(string $id)
    {
        $cart = $this->finder->__invoke($id);

        $totals =  $this->cartItemsTotalizator->__invoke($id);

        $cart->totalsUpdater($totals['totalItems'], $totals['total']);

        $this->repository->save($cart);
    }
}
