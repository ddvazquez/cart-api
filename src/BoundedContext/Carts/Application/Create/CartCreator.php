<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Application\Create;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObjects\CartId;
use Spfc\Shared\Domain\Bus\Event\EventBus;

final class CartCreator
{
    private CartRepository $repository;

    private EventBus $bus;

    /**
     * @param  CartRepository  $repository
     * @param  EventBus  $bus
     */
    public function __construct(CartRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    /**
     * @param string $id
     * @return void
     */
    public function __invoke(string $id)
    {
        $isIdUnique = $this->repository->isIdUnique($id);

        $id = new CartId($id);

        $cart = Cart::create($id, $isIdUnique);

        $this->repository->save($cart);

        $this->bus->publish(...$cart->pullDomainEvents());
    }
}
