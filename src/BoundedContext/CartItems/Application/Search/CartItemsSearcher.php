<?php declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Search;

use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;

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
