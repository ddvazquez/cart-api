<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Domain;

use Spfc\Shared\Domain\Bus\Event\DomainEvent;

final class CartItemCreatedDomainEvent extends DomainEvent
{
    private string $cartId;
    private string $productId;
    private string $name;
    private string $description;
    private float $price;

    /**
     * @param string $id
     * @param string $cartId
     * @param string $productId
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string|null $eventId
     * @param string|null $occurredOn
     */
    public function __construct(
        string $id,

        string $cartId,
        string $productId,
        string $name,
        string $description,
        float $price,

        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public static function eventName(): string
    {
        return 'cartItem.created';
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            'cartId' => $this->cartId,
            'productId' => $this->productId,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }

    /**
     * @param  string  $aggregateId
     * @param  array  $body
     * @param  string  $eventId
     * @param  string  $occurredOn
     * @return CartItemCreatedDomainEvent
     */
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): CartItemCreatedDomainEvent {
        return new self($aggregateId, $body['cartId'], $body['productId'], $body['name'], $body['description'], $body['price'], $eventId, $occurredOn);
    }

    /**
     * @return string
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * @return string
     */
    public function productId(): string
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->price;
    }}
