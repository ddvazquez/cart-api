<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Application\Create;

use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Application\Update\CartPayer;
use Spfc\Tests\Shop\Carts\CartsModuleUnitTestCase;
use Spfc\Tests\Shop\Carts\Domain\CartMother;
use Spfc\Tests\Shop\Shared\Domain\CartIdMother;

final class CartPayerTest extends CartsModuleUnitTestCase
{
    private CartPayer $payer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->payer =new CartPayer($this->repository(), new CartFinder($this->repository()));
    }

    /** @test */
    public function it_should_pay_a_cart(): void
    {
        $cart  = CartMother::random();

        $this->shouldSearch($cart->id(), $cart);
        $this->shouldSave($cart);

        $this->payer->__invoke($cart->id()->value());

        $this->assertEquals(true, $cart->paid()->value());
    }
}
