<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Application\Create;

use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Shop\Carts\Application\Update\CartPayer;
use Spfc\Tests\Shop\Carts\CartsModuleUnitTestCase;
use Spfc\Tests\Shop\Carts\Domain\CartIdMother;
use Spfc\Tests\Shop\Carts\Domain\CartMother;

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
        $id = CartIdMother::random();
        $cart  = CartMother::create($id);

        $this->shouldSearch($id, $cart);
        $this->shouldSave($cart);

        $this->payer->__invoke($id->value());

        $this->assertEquals(true, $cart->paid()->value());
    }
}
