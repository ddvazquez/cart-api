<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts;

use Spfc\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Spfc\Shop\Carts\Domain\Cart;
use Spfc\Shop\Carts\Domain\CartRepository;
use Spfc\Shop\Shared\Domain\ValueObject\CartId;

use Mockery\MockInterface;

abstract class CartsModuleUnitTestCase extends UnitTestCase
{
    private $repository;

    /**
     * @param Cart $cart
     * @return void
     */
    protected function shouldSave(Cart $cart): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($cart))
            ->once()
            ->andReturnNull();
    }

    /**
     * @param CartId $id
     * @param Cart|null $cart
     * @return void
     */
    protected function shouldSearch(CartId $id, ?Cart $cart): void
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
     * @return MockInterface|CartRepository
     */
    protected function repository(): MockInterface | CartRepository
    {
        return $this->repository = $this->repository ?: $this->mock(CartRepository::class);
    }
}
