<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\Bus\Event;

interface EventBus
{
    /**
     * @param  DomainEvent  ...$events
     * @return void
     */
    public function publish(DomainEvent ...$events): void;
}
