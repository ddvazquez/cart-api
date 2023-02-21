<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Create;

use Spfc\BoundedContext\CartItems\Domain\CartItem;
use Spfc\BoundedContext\CartItems\Domain\CartItemDescription;
use Spfc\BoundedContext\CartItems\Domain\CartItemId;
use Spfc\BoundedContext\CartItems\Domain\CartItemName;
use Spfc\BoundedContext\CartItems\Domain\CartItemPrice;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\Carts\Application\Find\CartFinder;
use Spfc\BoundedContext\Carts\Application\Update\CartTotalsIncrementer;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;
use Spfc\BoundedContext\Shared\Domain\ValueObject\ProductId;
use function Lambdish\Phunctional\apply;

final class CartItemCreator
{
    private CartItemRepository $repository;
    private CartTotalsIncrementer $cartTotalsIncrementer;
    private CartFinder $cartFinder;

    /**
     * @param CartItemRepository $repository
     * @param CartFinder $cartFinder
     * @param CartTotalsIncrementer $cartTotalsIncrementer
     */
    public function __construct(CartItemRepository $repository, CartFinder $cartFinder, CartTotalsIncrementer $cartTotalsIncrementer)
    {
        $this->repository = $repository;
        $this->cartFinder = $cartFinder;
        $this->cartTotalsIncrementer = $cartTotalsIncrementer;
    }

    /**
     * @param CreateCartItemRequest $request
     * @return void
     */
    public function __invoke(CreateCartItemRequest $request)
    {
        $id = new CartItemId($request->id());
        $cartId = new CartId($request->cartId());
        $productId = new ProductId($request->productId());
        $name = new CartItemName($request->name());
        $description = new CartItemDescription($request->description());
        $price = new CartItemPrice($request->price());

        $isIdUnique = $this->repository->isIdUnique($request->id());

        $cartItem = CartItem::create($id, $cartId, $productId, $name, $description, $price, $isIdUnique);

        $cart = $this->cartFinder->__invoke($cartId->value());

        if($cart->payed()->value()) {
            throw new \InvalidArgumentException(
                sprintf('<%s> cart is already payed.', $cartId->value())
            );
        }

        $this->repository->save($cartItem);

        apply($this->cartTotalsIncrementer, [$request->cartId(), $request->price()]);
    }
}
