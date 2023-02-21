<?php declare(strict_types=1);

namespace Spfc\Shop\Carts\Application\Find;

use Spfc\Shop\Carts\Domain\Cart;
use Spfc\Shop\Carts\Domain\CartNotExist;
use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;

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
