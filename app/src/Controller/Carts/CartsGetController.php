<?php
declare(strict_types=1);

namespace App\Src\Controller\Carts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\Shop\Carts\Application\CartResponse;
use Spfc\Shop\Carts\Application\Create\CartCreator;
use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Application\Update\CartPayer;
use function Lambdish\Phunctional\map;


class CartsGetController extends BaseController
{
    private CartFinder $finder;

    /**
     * @param  CartFinder $finder
     */
    public function __construct(CartFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param string $cartId
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(string $cartId, Request $request): JsonResponse
    {
        try {
            $cart = $this->finder->__invoke($cartId);

            return new JsonResponse(
                $cart->toPrimitives(),
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        } catch (\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
