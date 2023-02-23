<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\Carts\Application\Create;

use Spfc\Shop\Carts\Application\Create\CartCreator;
use Spfc\Tests\Shop\Carts\CartsModuleUnitTestCase;
use Spfc\Tests\Shop\Carts\Domain\CartIdMother;
use Spfc\Tests\Shop\Carts\Domain\CartMother;

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
        $id = CartIdMother::random();
        $cart  = CartMother::create($id);

        $this->isIdUnique($id->value());

        $this->shouldSave($cart);

        $this->creator->__invoke($id->value());
    }
}
