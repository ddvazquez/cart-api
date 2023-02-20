<?php declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Application\Find;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartNotExist;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObjects\CartId;

final class CartFinder
{

    private CartRepository $repository;

    /**
     * @param CartRepository $repository
     */
    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $id
     * @return Cart
     */
    public function __invoke(string $id): Cart
    {
        $id = new CartId($id);

        $cart = $this->repository->search($id);

        if (null === $cart) {
            throw new CartNotExist($id);
        }

        return $cart;
    }
}
