<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus\Event\InMemory;

use Spfc\Shared\Domain\Bus\Event\DomainEvent;
use Spfc\Shared\Domain\Bus\Event\EventBus;
use Spfc\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBus implements EventBus
{
    private MessageBus $bus;

    /**
     * @param  iterable  $subscribers
     */
    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
                    )
                ),
            ]
        );
    }

    /**
     * @param  DomainEvent  ...$events
     * @return void
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException $error) {
            }
        }
    }
}
