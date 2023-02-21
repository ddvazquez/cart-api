<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Application\Update;


use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Carts\Application\Find\CartFinder;

final class CartPayer
{
    private CartRepository $repository;
    private CartFinder $finder;

    /**
     * @param CartRepository $repository
     */
    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
        $this->finder     = new CartFinder($repository);
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
