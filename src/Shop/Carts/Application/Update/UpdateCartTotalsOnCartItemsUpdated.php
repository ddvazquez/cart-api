<?php

declare(strict_types=1);

namespace Spfc\Shop\Carts\Application\Update;

use CodelyTv\Mooc\Shared\Domain\Course\CourseId;
use Spfc\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Spfc\Shop\CartItems\Domain\CartItemUpdatedDomainEvent;

final class UpdateCartTotalsOnCartItemsUpdated implements DomainEventSubscriber
{
    private CartTotalsUpdater $updater;

    /**
     * @param CartTotalsUpdater $updater
     */
    public function __construct(CartTotalsUpdater $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @return string[]
     */
    public static function subscribedTo(): array
    {
        return [CartItemUpdatedDomainEvent::class];
    }

    /**
     * @param  CartItemUpdatedDomainEvent  $event
     * @return void
     */
    public function __invoke(CartItemUpdatedDomainEvent $event): void
    {
        $this->updater->__invoke($event->cartId());
    }
}
