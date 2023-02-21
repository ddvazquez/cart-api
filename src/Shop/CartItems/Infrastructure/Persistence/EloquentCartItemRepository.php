<?php

declare(strict_types=1);

namespace Spfc\Shop\CartItems\Infrastructure\Persistence;

use Spfc\Shop\CartItems\Domain\CartItem;
use Spfc\Shop\CartItems\Domain\CartItemDescription;
use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemName;
use Spfc\Shop\CartItems\Domain\CartItemPrice;
use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\CartItems\Infrastructure\Persistence\Eloquent\CartItemEloquentModel;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shop\Shared\Domain\ValueObject\ProductId;

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
     * @param CartItemId $id
     * @return void
     */
    public function delete(CartItemId $id): void
    {
        $model = CartItemEloquentModel::find($id->value());
        $model->delete();
    }

    /**
     * @param CartItemId $id
     * @return CartItem|null
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
     * @param CartId $cartId
     * @return array
     */
    public function searchByCartId(CartId $cartId) : array
    {
        $cartItems = CartItemEloquentModel::where('cart_id', $cartId->value())->get()->toArray();

        return $cartItems;
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
