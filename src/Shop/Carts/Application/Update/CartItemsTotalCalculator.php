<?php declare(strict_types=1);

namespace Spfc\Shop\Carts\Application\Update;


use Spfc\Shop\CartItems\Application\Search\CartItemsSearcher;
use Spfc\Shop\Carts\Domain\CartTotal;
use Spfc\Shop\Carts\Domain\CartTotalItems;
use function Lambdish\Phunctional\apply;

final class CartItemsTotalCalculator
{
    private CartItemsSearcher $searcher;

    /**
     * @param CartItemsSearcher $searcher
     */
    public function __construct(CartItemsSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    /**
     * @param string $cartId
     * @return array
     */
    public function __invoke(string $cartId): array
    {
        $cartItems = apply($this->searcher, [$cartId]);

        $totals = [
            'totalItems' => new CartTotalItems(count($cartItems)),
            'total' => new CartTotal(array_sum(array_column($cartItems, 'price')))
        ];

        return $totals;
    }
}
