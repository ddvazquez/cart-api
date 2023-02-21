<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Infrastructure\Persistence;

use Spfc\BoundedContext\Carts\Domain\Cart;
use Spfc\BoundedContext\Carts\Domain\CartDate;
use Spfc\BoundedContext\Carts\Domain\CartPayed;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Carts\Domain\CartTotal;
use Spfc\BoundedContext\Carts\Domain\CartTotalItems;
use Spfc\BoundedContext\Carts\Infrastructure\Persistence\Eloquent\CartEloquentModel;
use Spfc\BoundedContext\Shared\Domain\ValueObject\CartId;


final class EloquentCartRepository implements CartRepository
{
    /**
     * @param  Cart  $cart
     * @return void
     */
    public function save(Cart $cart): void
    {
        CartEloquentModel::updateOrCreate(
            ['id' => $cart->id()->value()],
            [
                'payed' => $cart->payed()->value(),
                'total_items' => $cart->totalItems()->value(),
                'total' => $cart->total()->value(),
                'date' => $cart->date()->value(),
            ]
        );
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

        return new Cart(new CartId($model->id), new CartPayed($model->payed),  new CartTotalItems($model->total_items), new CartTotal($model->total), new CartDate($model->date));
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
