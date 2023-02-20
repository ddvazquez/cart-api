<?php
declare(strict_types=1);

namespace App\Src\Controller\CartItems;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\BoundedContext\CartItems\Application\Create\CartItemCreator;
use Spfc\BoundedContext\CartItems\Application\Create\CreateCartItemRequest;


class CartItemsPutController extends BaseController
{
    private CartItemCreator $creator;

    /**
     * @param  CartItemCreator  $creator
     */
    public function __construct(CartItemCreator $creator)
    {
        $this->creator = $creator;
    }

    /**
     * @param string $cartId
     * @param string $cartItemId
     * @param Request $request
     * @return Response
     */
    public function __invoke(string $cartId, string $cartItemId, Request $request): Response
    {
        try {
            $this->creator->__invoke(
                new CreateCartItemRequest(
                    $cartItemId,
                    $cartId,
                    $request

                )
            );

            return new response('', Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
