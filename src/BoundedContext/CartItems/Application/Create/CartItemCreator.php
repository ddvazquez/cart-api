<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Create;

use Spfc\BoundedContext\CartItems\Domain\CartItem;
use Spfc\BoundedContext\CartItems\Domain\CartItemDescription;
use Spfc\BoundedContext\CartItems\Domain\CartItemId;
use Spfc\BoundedContext\CartItems\Domain\CartItemName;
use Spfc\BoundedContext\CartItems\Domain\CartItemPrice;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\Shared\Domain\ValueObjects\CartId;
use Spfc\BoundedContext\Shared\Domain\ValueObjects\ProductId;
use Spfc\Shared\Domain\Bus\Event\EventBus;

final class CartItemCreator
{
    private CartItemRepository $repository;

    private EventBus $bus;

    /**
     * @param  CartItemRepository  $repository
     * @param  EventBus  $bus
     */
    public function __construct(CartItemRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
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

        $this->repository->save($cartItem);

        $this->bus->publish(...$cartItem->pullDomainEvents());
    }
}
