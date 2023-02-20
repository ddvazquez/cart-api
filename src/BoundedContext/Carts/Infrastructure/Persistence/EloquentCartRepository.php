<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Infrastructure\Persistence;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Carts\Infrastructure\Persistence\Eloquent\CartEloquentModel;
use Spfc\BoundedContext\Shared\Domain\ValueObjects\CartId;


final class EloquentCartRepository implements CartRepository
{
    /**
     * @param  Cart  $cart
     * @return void
     */
    public function save(Cart $cart): void
    {
        $model = new CartEloquentModel();
        $model->id = $cart->id()->value();
        $model->payed = $cart->payed()->value();
        $model->total_items = $cart->totalItems()->value();
        $model->total = $cart->total()->value();
        $model->date = $cart->date()->value();

        $model->save();
    }

    /**
     * @param  CartId  $id
     * @return Cart|null
     */
    public function search(CartId $id): ?Cart
    {
        $model = CartEloquentModel::find($id->value());

        if (null === $model) {
            return null;
        }

        return $model;
    }

    /**
     * @param  string  $id
     * @return bool|null
     */
    public function isIdUnique(string $id): ?bool
    {
        return ! CartEloquentModel::where('id', '=', $id)->count();
    }
}
