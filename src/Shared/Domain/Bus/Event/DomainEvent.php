<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Spfc\Shared\Domain\Utils;
use Spfc\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private string $aggregateId;

    private string|null $eventId;

    private string|null $occurredOn;

    /**
     * @param  string  $aggregateId
     * @param  string|null  $eventId
     * @param  string|null  $occurredOn
     */
    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    /**
     * @return string
     */
    abstract public static function eventName(): string;

    /**
     * @return array
     */
    abstract public function toPrimitives(): array;

    /**
     * @param  string  $aggregateId
     * @param  array  $body
     * @param  string  $eventId
     * @param  string  $occurredOn
     * @return static
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    /**
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    /**
     * @return string|null
     */
    public function eventId(): ?string
    {
        return $this->eventId;
    }

    /**
     * @return string|null
     */
    public function occurredOn(): ?string
    {
        return $this->occurredOn;
    }
}
