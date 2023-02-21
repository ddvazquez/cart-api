<?php

declare(strict_types = 1);

namespace Spfc\BoundedContext\Carts\Application\Update;


use Spfc\BoundedContext\Carts\Application\Find\CartFinder;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;
use Spfc\Shared\Domain\Bus\Event\EventBus;

final class CartTotalsDecrementer
{
    private CartRepository $repository;
    private CartFinder $finder;

    /**
     * @param CartRepository $repository
     */
    public function __construct(CartRepository $repository) {
        $this->repository    = $repository;
        $this->finder     = new CartFinder($repository);
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
