<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Spfc\BoundedContext\CartItems\Domain\CartItemRepository;
use Spfc\BoundedContext\CartItems\Infrastructure\Persistence\EloquentCartItemRepository;


final class CartItemServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CartItemRepository::class => EloquentCartItemRepository::class,
    ];
}
