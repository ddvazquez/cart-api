<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Infrastructure\Persistence;

use Spfc\BoundedContext\CartItems\Domain\CartItem;
use Spfc\BoundedContext\CartItems\Domain\CartItemDescription;
use Spfc\BoundedContext\CartItems\Domain\CartItemId;
use Spfc\BoundedContext\CartItems\Domain\CartItemName;
use Spfc\BoundedContext\CartItems\Domain\CartItemPrice;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\CartItems\Infrastructure\Persistence\Eloquent\CartItemEloquentModel;
use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartDate;
use Spfc\BoundedContext\Carts\Domain\CartPayed;
use Spfc\BoundedContext\Carts\Domain\CartTotal;
use Spfc\BoundedContext\Carts\Domain\CartTotalItems;
use Spfc\BoundedContext\Carts\Infrastructure\Persistence\Eloquent\CartEloquentModel;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;
use Spfc\BoundedContext\Shared\Domain\ValueObject\ProductId;

final class EloquentCartItemRepository implements CartItemRepository
{
    /**
     * @param CartItem $cartItem
     * @return void
     */
    public function save(CartItem $cartItem): void
    {
        CartItemEloquentModel::updateOrCreate(
            ['id' => $cartItem->id()->value()],
            [
            'cart_id' => $cartItem->cartId()->value(),
            'product_id'=> $cartItem->productId()->value(),
            'name' => $cartItem->name()->value(),
            'description' => $cartItem->description()->value(),
            'price' => $cartItem->price()->value(),
            ]
        );
    }

    /**
     * @param CartItem $cartItem
     * @return void
     */
    public function delete(CartItemId $id): void
    {
        $model = CartItemEloquentModel::find($id->value());
        $model->delete();
    }

    /**
     * @param CartItemId $id
     * @return Cart|null
     */
    public function search(CartItemId $id): ?CartItem
    {
        $model = CartItemEloquentModel::find($id->value());

        if (null === $model) {
            return null;
        }

        return new CartItem(new CartItemId($model->id), new CartId($model->cart_id),  new ProductId($model->product_id),  new CartItemName($model->name), new CartItemDescription($model->description), new CartItemPrice($model->price));
    }

    /**
     * @param  string  $id
     * @return bool|null
     */
    public function isIdUnique(string $id): ?bool
    {
        return ! CartItemEloquentModel::where('id', '=', $id)->count();
    }
}
