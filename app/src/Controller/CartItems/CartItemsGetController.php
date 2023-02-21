<?php
declare(strict_types=1);

namespace App\Src\Controller\CartItems;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\Shop\CartItems\Application\Search\CartItemsSearcher;
use Spfc\Shop\Carts\Application\CartResponse;

class CartItemsGetController extends BaseController
{
    private CartItemsSearcher $searcher;

    /**
     * @param  CartItemsSearcher $searcher
     */
    public function __construct(CartItemsSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    /**
     * @param string $cartId
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(string $cartId, Request $request): JsonResponse
    {
        try {
            $cartItems = $this->searcher->__invoke($cartId);

            return new JsonResponse(
                $cartItems,
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        } catch (\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
