<?php

declare(strict_types=1);

namespace Spfc\Shop\CartItems\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\CartItems\Infrastructure\Persistence\EloquentCartItemRepository;

final class CartItemServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CartItemRepository::class => EloquentCartItemRepository::class,
    ];
}
