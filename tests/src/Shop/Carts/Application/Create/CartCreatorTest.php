<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Application\Create;

use Spfc\Shop\Carts\Application\Create\CartCreator;
use Spfc\Tests\Shop\Carts\CartsModuleUnitTestCase;

use Spfc\Tests\Shop\Carts\Domain\CartMother;
use Spfc\Tests\Shop\Shared\Domain\CartIdMother;


final class CartCreatorTest extends CartsModuleUnitTestCase
{
    private CartCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator =new CartCreator($this->repository());
    }

    /** @test */
    public function it_should_create_a_valid_cart(): void
    {
        $cart  = CartMother::random();

        $this->isIdUnique($cart->id()->value());

        $this->shouldSave($cart);

        $this->creator->__invoke($cart->id()->value());
    }
}
