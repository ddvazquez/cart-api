<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems;

use Spfc\Shop\CartItems\Domain\CartItem;
use Spfc\Shop\CartItems\Domain\CartItemId;
use Spfc\Shop\CartItems\Domain\CartItemRepository;
use Spfc\Shop\Carts\Domain\Cart;
use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

use Mockery\MockInterface;

abstract class CartItemsModuleUnitTestCase extends UnitTestCase
{
    private  $repository;
    private  $cartRepository;

    protected function shouldSave(CartItem $cart): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($cart))
            ->once()
            ->andReturnNull();
    }

    protected function shouldSearch(CartItemId $id, ?CartItem $cart): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->with($this->similarTo($id))
            ->once()
            ->andReturn($cart);
    }

    /**
     * @param string $id
     * @return void
     */
    protected function isIdUnique(string $id): void
    {
        $this->repository()->shouldReceive('isIdUnique')
            ->once()
            ->with($id)
            ->andReturn(true);
    }

    /**
     * @return MockInterface|CartItemRepository
     */
    protected function repository(): MockInterface | CartItemRepository
    {
        return $this->repository = $this->repository ?: $this->mock(CartItemRepository::class);
    }
}
