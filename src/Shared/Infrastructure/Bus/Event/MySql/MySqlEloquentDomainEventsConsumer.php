<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus\Event\MySql;

use DateTimeImmutable;
use Exception;
use Illuminate\Database\Connection;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;
use Spfc\Shared\Domain\Utils;
use Spfc\Shared\Infrastructure\Bus\Event\DomainEventMapping;

final class MySqlEloquentDomainEventsConsumer
{
    private Connection $connection;

    private DomainEventMapping $eventMapping;

    /**
     * @param  Connection  $connection
     * @param  DomainEventMapping  $eventMapping
     */
    public function __construct(Connection $connection, DomainEventMapping $eventMapping)
    {
        $this->connection = $connection;
        $this->eventMapping = $eventMapping;
    }

    /**
     * @param  callable  $subscribers
     * @param  int  $eventsToConsume
     * @return void
     */
    public function consume(callable $subscribers, int $eventsToConsume): void
    {
        $events = $this->connection->table('domain_events')->limit($eventsToConsume)->orderBy('occurred_on')->get()->map(fn ($row) => (array) $row);

        each($this->executeSubscribers($subscribers), $events);

        $ids = implode(', ', map($this->idExtractor(), $events));

        if (! empty($ids)) {
            $this->connection->statement("DELETE FROM domain_events WHERE id IN ($ids)");
        }
    }

    /**
     * @param  callable  $subscribers
     * @return callable
     */
    private function executeSubscribers(callable $subscribers): callable
    {
        return function (array $rawEvent) use ($subscribers): void {
            try {
                $domainEventClass = $this->eventMapping->for($rawEvent['name']);
                $domainEvent = $domainEventClass::fromPrimitives(
                    $rawEvent['aggregate_id'],
                    Utils::jsonDecode($rawEvent['body']),
                    $rawEvent['id'],
                    $this->formatDate($rawEvent['occurred_on'])
                );

                $subscribers($domainEvent);
            } catch (\RuntimeException $error) {
            }
        };
    }

    /**
     * @param $stringDate
     * @return string
     *
     * @throws Exception
     */
    private function formatDate($stringDate): string
    {
        return Utils::dateToString(new DateTimeImmutable($stringDate));
    }

    /**
     * @return callable
     */
    private function idExtractor(): callable
    {
        return static function (array $event): string {
            return "'${event['id']}'";
        };
    }
}
