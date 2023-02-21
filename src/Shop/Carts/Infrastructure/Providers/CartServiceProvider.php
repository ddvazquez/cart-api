<?php

declare(strict_types=1);

namespace Spfc\Shop\Carts\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Carts\Infrastructure\Persistence\EloquentCartRepository;

final class CartServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CartRepository::class => EloquentCartRepository::class,
    ];
}
