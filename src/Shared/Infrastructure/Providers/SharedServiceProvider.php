<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Spfc\BoundedContext\Carts\Application\Update\UpdateTotalsOnCartItemCreated;
use Spfc\Shared\Domain\Bus\Event\EventBus;
use Spfc\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use Spfc\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use Spfc\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use Spfc\Shared\Infrastructure\Bus\Event\MySql\MySqlEloquentEventBus;

final class SharedServiceProvider extends ServiceProvider
{
    public array $bindings = [
        EventBus::class => MySqlEloquentEventBus::class, //InMemorySymfonyEventBus::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->tag([
            UpdateTotalsOnCartItemCreated::class,
        ], 'domain_event_subscriber');

        $this->app->bind(InMemorySymfonyEventBus::class, function (Application $app) {
            return new InMemorySymfonyEventBus($app->tagged('domain_event_subscriber'));
        });

        $this->app->bind(DomainEventMapping::class, function (Application $app) {
            return new DomainEventMapping($app->tagged('domain_event_subscriber'));
        });

        $this->app->bind(DomainEventSubscriberLocator::class, function (Application $app) {
            return new DomainEventSubscriberLocator($app->tagged('domain_event_subscriber'));
        });
    }
}
