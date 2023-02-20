<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Domain;

use Spfc\BoundedContext\CartItems\Domain\CartItemCreatedDomainEvent;
use Spfc\Shared\Domain\Bus\Event\DomainEvent;

final class CartPayedDomainEvent extends DomainEvent
{
    private bool $payed;
    private int $totalItems;
    private float $total;
    private string $date;

    /**
     * @param string $id
     * @param bool $payed
     * @param int $totalItems
     * @param float $total
     * @param string $date
     * @param string|null $eventId
     * @param string|null $occurredOn
     */
    public function __construct(
        string $id,
        bool $payed,
        int $totalItems,
        float $total,
        string $date,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->payed = $payed;
        $this->totalItems = $totalItems;
        $this->total = $total;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public static function eventName(): string
    {
        return 'cart.payed';
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            'payed' => $this->payed,
            'totalItems' => $this->totalItems,
            'total' => $this->total,
            'date' => $this->date,
        ];
    }

    /**
     * @param  string  $aggregateId
     * @param  array  $body
     * @param  string  $eventId
     * @param  string  $occurredOn
     * @return CartPayedDomainEvent
     */
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): CartPayedDomainEvent {
        return new self($aggregateId, $body['payed'], $body['totalItems'], $body['total'], $body['date'], $eventId, $occurredOn);
    }

    /**
     * @return bool
     */
    public function payed(): bool
    {
        return $this->payed;
    }

    /**
     * @return int
     */
    public function totalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * @return float
     */
    public function total(): float
    {
        return $this->total;
    }

    /**
     * @return string
     */
    public function date(): string
    {
        return $this->date;
    }
}
