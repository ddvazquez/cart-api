<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shop\CartItems\Application\Create;

use Spfc\Shop\CartItems\Application\Create\CartItemCreator;
use Spfc\Shop\Carts\Application\Find\CartFinder;
use Spfc\Tests\Shop\CartItems\Domain\CartItemMother;
use Spfc\Tests\Shop\CartItems\CartItemsModuleUnitTestCase;
use Spfc\Tests\Shop\CartItems\Domain\CartItemUpdatedDomainEventMother;
use Spfc\Tests\Shop\Carts\Domain\CartMother;

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

    /** @test */
    public function it_should_create_a_valid_cart_item(): void
    {
        $cart  = CartMother::random();

        $cartItemRequest = CreateCartItemRequestMother::random();

        $cartItem = CartItemMother::fromRequest($cartItemRequest);

        $domainEvent = CartItemUpdatedDomainEventMother::fromCartIte($cartItem);

        $this->cartShouldSearch($cartItem->cartId(), $cart);

        $this->isIdUnique($cartItemRequest->id());

        $this->shouldSave($cartItem);

        $this->shouldPublishDomainEvent($domainEvent);

        $this->creator->__invoke($cartItemRequest);
    }
}
