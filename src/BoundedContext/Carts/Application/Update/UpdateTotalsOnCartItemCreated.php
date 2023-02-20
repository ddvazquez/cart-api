<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Application\Update;

use Spfc\BoundedContext\CartItems\Domain\CartItemCreatedDomainEvent;
use Spfc\Shared\Domain\Bus\Event\DomainEventSubscriber;
use function Lambdish\Phunctional\apply;

final class UpdateTotalsOnCartItemCreated implements DomainEventSubscriber
{
    private CartTotalsUpdater $totalUpdater;

    /**
     * @param CartTotalsUpdater $totalUpdater
     */
    public function __construct(CartTotalsUpdater $totalUpdater)
    {
        $this->totalUpdater = $totalUpdater;
    }

    /**
     * @return string[]
     */
    public static function subscribedTo(): array
    {
        return [CartItemCreatedDomainEvent::class];
    }

    /**
     * @param CartItemCreatedDomainEvent $event
     * @return void
     */
    public function __invoke(CartItemCreatedDomainEvent $event): void
    {
        // TODO
        /*$price = $event->price();

        apply($this->totalUpdater, [$price]);*/
    }
}
