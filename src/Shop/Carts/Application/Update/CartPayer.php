<?php

declare(strict_types=1);

namespace Spfc\Shop\Carts\Application\Update;

use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Carts\Application\Find\CartFinder;

final class CartPayer
{
    private CartRepository $repository;
    private CartFinder $finder;

    /**
     * @param CartRepository $repository
     * @param CartFinder $cartFinder
     */
    public function __construct(CartRepository $repository, CartFinder $cartFinder)
    {
        $this->repository = $repository;
        $this->finder     = $cartFinder;
    }

    /**
     * @param string $id
     * @return void
     */
    public function __invoke(string $id): void
    {
        $cart = $this->finder->__invoke($id);

        $cart->pay();

        $this->repository->save($cart);
    }
}
