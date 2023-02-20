<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Spfc\BoundedContext\Carts\Domain\CartRepository;
use Spfc\BoundedContext\Carts\Infrastructure\Persistence\EloquentCartRepository;

final class CartServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CartRepository::class => EloquentCartRepository::class,
    ];
}
