<?php

declare(strict_types=1);

namespace Spfc\Shop\Carts\Infrastructure\Persistence;

use Spfc\Shop\Carts\Domain\Cart;
use Spfc\Shop\Carts\Domain\CartDate;
use Spfc\Shop\Carts\Domain\CartPayed;
use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Carts\Domain\CartTotal;
use Spfc\Shop\Carts\Domain\CartTotalItems;
use Spfc\Shop\Carts\Infrastructure\Persistence\Eloquent\CartEloquentModel;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;


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
