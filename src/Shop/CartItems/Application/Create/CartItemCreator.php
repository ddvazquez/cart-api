<?php

declare(strict_types=1);

namespace Spfc\Shop\CartItems\Application\Create;

use Spfc\Shared\Domain\Bus\Event\EventBus;
use Spfc\Shop\CartItems\Domain\CartItem;
use Spfc\Shop\CartItems\Domain\CartItemDescription;
use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Shop\CartItems\Domain\CartItemPrice;
use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Application\Update\CartTotalsIncrementer;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;
use function Lambdish\Phunctional\apply;

final class CartItemCreator
{
    private CartItemRepository $repository;
    private CartFinder $cartFinder;
    private EventBus $bus;

    /**
     * @param CartItemRepository $repository
     * @param CartFinder $cartFinder
     * @param EventBus $bus
     */
    public function __construct(CartItemRepository $repository, CartFinder $cartFinder, EventBus $bus)
    {
        $this->repository = $repository;
        $this->cartFinder = $cartFinder;
        $this->bus = $bus;
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

        if($cart->paid()->value()) {
            throw new \InvalidArgumentException(
                sprintf('<%s> cart is already payed.', $cartId->value())
            );
        }

        $this->repository->save($cartItem);

        $this->bus->publish(...$cartItem->pullDomainEvents());
    }
}
