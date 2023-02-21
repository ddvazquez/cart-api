<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

final class CartItemEloquentModel extends Model
{
    protected $table = 'cart_items';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['id', 'cart_id', 'product_id', 'name', 'description', 'price'];
}
