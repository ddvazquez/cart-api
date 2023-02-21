<?php declare(strict_types=1);

namespace Spfc\Shop\CartItems\Application\Search;

use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;

final class CartItemsSearcher
{
    private CartItemRepository $repository;

    /**
     * @param CartItemRepository $repository
     */
    public function __construct(CartItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $cartId
     * @return array
     */
    public function __invoke(string $cartId): array
    {
        $cartId = new CartId($cartId);

        $cartItems = $this->repository->searchByCartId($cartId);

        return $cartItems;
    }
}
