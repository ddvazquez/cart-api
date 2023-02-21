<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Application\Create;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;

final class CartCreator
{
    private CartRepository $repository;

    /**
     * @param  CartRepository  $repository
     */
    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
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
    }
}
