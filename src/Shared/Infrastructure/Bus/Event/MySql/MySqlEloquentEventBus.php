<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus\Event\MySql;

use Illuminate\Database\Connection;
use function Lambdish\Phunctional\each;
use Spfc\Shared\Domain\Bus\Event\DomainEvent;
use Spfc\Shared\Domain\Bus\Event\EventBus;
use Spfc\Shared\Domain\Utils;

final class MySqlEloquentEventBus implements EventBus
{
    private const DATABASE_TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    private Connection $connection;

    /**
     * @param  Connection  $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  DomainEvent  ...$domainEvents
     * @return void
     */
    public function publish(DomainEvent ...$domainEvents): void
    {
        each($this->publisher(), $domainEvents);
    }

    /**
     * @return callable
     */
    private function publisher(): callable
    {
        return function (DomainEvent $domainEvent): void {
            $id = $this->connection->getPdo()->quote($domainEvent->eventId());
            $aggregateId = $this->connection->getPdo()->quote($domainEvent->aggregateId());
            $name = $this->connection->getPdo()->quote($domainEvent::eventName());
            $body = $this->connection->getPdo()->quote(Utils::jsonEncode($domainEvent->toPrimitives()));
            $occurredOn = $this->connection->getPdo()->quote(
                Utils::stringToDate($domainEvent->occurredOn())->format(self::DATABASE_TIMESTAMP_FORMAT)
            );

            $this->connection->statement(
                <<<SQL
                INSERT INTO domain_events (id,  aggregate_id, name,  body,  occurred_on)
                                   VALUES ($id, $aggregateId, $name, $body, $occurredOn);
SQL
            );
        };
    }
}
