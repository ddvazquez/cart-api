<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Application\Create;

use Spfc\Shop\CartItems\Application\Create\CartItemCreator;
use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Tests\Shop\CartItems\Domain\CartItemMother;
use Spfc\Tests\Shop\CartItems\CartItemsModuleUnitTestCase;

final class CartItemCreatorTest extends CartItemsModuleUnitTestCase
{
    private CartItemCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator =new CartItemCreator(
            $this->repository(),
            new CartFinder($this->cartRepository()),
            $this->eventBus()
        );
    }

    /** @testPending */
    public function it_should_create_a_valid_cart_item(): void
    {
        $cartItemRequest = CreateCartItemRequestMother::random();

        $cartItem = CartItemMother::fromRequest($cartItemRequest);



        $this->isIdUnique($cartItemRequest->id());

        $this->shouldSave($cartItem);

        $this->creator->__invoke($cartItemRequest);

    }
}
