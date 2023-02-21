<?php
declare(strict_types=1);

namespace App\Src\Controller\Carts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spfc\Shop\Carts\Application\Update\CartPayer;

class CartsPayPutController extends BaseController
{
    private CartPayer $payer;

    /**
     * @param  CartPayer  $payer
     */
    public function __construct(CartPayer $payer)
    {
        $this->payer = $payer;
    }

    /**
     * @param string $cartId
     * @param Request $request
     * @return Response
     */
    public function __invoke(string $cartId, Request $request): Response
    {
        try {
            $this->payer->__invoke($cartId);

            return new response('', Response::HTTP_OK);
        } catch (\InvalidArgumentException $ex) {
            return new response($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
