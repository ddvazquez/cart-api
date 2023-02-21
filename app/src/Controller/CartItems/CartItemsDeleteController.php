<?php
declare(strict_types=1);

namespace App\Src\Controller\CartItems;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\BoundedContext\CartItems\Application\Delete\CartItemDeleter;


class CartItemsDeleteController extends BaseController
{
    private CartItemDeleter $deleter;

    /**
     * @param  CartItemDeleter  $deleter
     */
    public function __construct(CartItemDeleter $deleter)
    {
        $this->deleter = $deleter;
    }

    /**
     * @param string $cartId
     * @param string $cartItemId
     * @return Response
     */
    public function __invoke(string $cartId, string $cartItemId): Response
    {
        try {
            $this->deleter->__invoke($cartItemId);

            return new response('', Response::HTTP_OK);
        } catch (\DomainException|\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
