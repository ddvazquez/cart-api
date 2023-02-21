<?php

declare(strict_types = 1);

namespace Spfc\BoundedContext\Carts\Application\Update;


use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;
use Spfc\Shared\Domain\Bus\Event\EventBus;

final class CartTotalsIncrementer
{
    private CartRepository $repository;

    /**
     * @param CartRepository $repository
     */
    public function __construct(CartRepository $repository) {
        $this->repository    = $repository;
    }

    public function __invoke(CartId $id,  float $price)
    {
        $cart = $this->repository->search($id);

        $cart->totalsIncrement($price);

        $this->repository->save($cart);
    }
}
