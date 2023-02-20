<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

final class CartEloquentModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['payed', 'total_items', 'total', 'date'];
}
