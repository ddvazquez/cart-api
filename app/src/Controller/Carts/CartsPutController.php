<?php
declare(strict_types=1);

namespace App\Src\Controller\Carts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\Shop\Carts\Application\Create\CartCreator;


class CartsPutController extends BaseController
{
    private CartCreator $creator;

    /**
     * @param  CartCreator  $creator
     */
    public function __construct(CartCreator $creator)
    {
        $this->creator = $creator;
    }

    /**
     * @param string $cartId
     * @param Request $request
     * @return Response
     */
    public function __invoke(string $cartId, Request $request): Response
    {
        try {
            $this->creator->__invoke($cartId);

            return new response('', Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
