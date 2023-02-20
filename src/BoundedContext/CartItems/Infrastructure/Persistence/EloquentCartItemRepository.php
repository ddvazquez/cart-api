<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Infrastructure\Persistence;

use Spfc\BoundedContext\CartItems\Domain\CartItem;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\CartItems\Infrastructure\Persistence\Eloquent\CartItemEloquentModel;

final class EloquentCartItemRepository implements CartItemRepository
{
    /**
     * @param CartItem $cartItem
     * @return void
     */
    public function save(CartItem $cartItem): void
    {
        $model = new CartItemEloquentModel();
        $model->id = $cartItem->id()->value();
        $model->cart_id = $cartItem->cartId()->value();
        $model->product_id = $cartItem->productId()->value();
        $model->name = $cartItem->name()->value();
        $model->description = $cartItem->description()->value();
        $model->price = $cartItem->price()->value();

        $model->save();
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
