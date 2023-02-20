<?php

declare(strict_types = 1);

namespace Spfc\BoundedContext\Carts\Application\Update;


use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\Shared\Domain\Bus\Event\EventBus;

final class CartTotalsUpdater
{
    private CartRepository $repository;
    private EventBus $bus;

    /**
     * @param CartRepository $repository
     * @param EventBus $bus
     */
    public function __construct(
        CartRepository $repository,
        EventBus $bus
    ) {

        $this->repository    = $repository;
        $this->bus     = $bus;
    }

    public function __invoke(float $price)
    {
        // TODO
        /*$cart = $this->repository->search();

        $cart->totalsUpdate($price);

        $this->repository->save($cart);*/
    }
}
