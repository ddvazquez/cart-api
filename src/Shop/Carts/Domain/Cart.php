<?php

declare(strict_types=1);

namespace Spfc\Shop\Carts\Domain;

use Spfc\Shop\Shared\Domain\ValueObject\CartId;
use Spfc\Shared\Domain\Aggregate\AggregateRoot;

final class Cart extends AggregateRoot
{
    private CartId $id;
    private CartPaid $paid;
    private CartTotalItems $totalItems;
    private CartTotal $total;
    private CartDate $date;

    /**+
     * @param CartId $id
     * @param CartPaid $paid
     * @param CartTotalItems $totalItems
     * @param CartTotal $total
     * @param CartDate $date
     */
    public function __construct(CartId $id, CartPaid $paid, CartTotalItems $totalItems, CartTotal $total, CartDate $date)
    {
        $this->id = $id;
        $this->paid = $paid;
        $this->totalItems = $totalItems;
        $this->total = $total;
        $this->date = $date;
    }

    /**
     * @param CartId $id
     * @param bool $isIdUnique
     * @return static
     */
    public static function create(CartId $id, bool $isIdUnique): self
    {
        if (! $isIdUnique) {
            throw new \InvalidArgumentException(
                sprintf('<%s> id already exists.', $id->value())
            );
        }

        $cart = new self($id, new CartPaid(false), new CartTotalItems(0), new CartTotal(0), new CartDate(date("Y-m-d H:i:s")));

        return $cart;
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id->value(),
            'paid'     => $this->paid->value(),
            'totalItems' => $this->totalItems->value(),
            'total' => $this->total->value(),
            'date' => $this->date->value(),
        ];
    }

    /**
     * @return CartId
     */
    public function id(): CartId
    {
        return $this->id;
    }

    /**
     * @return CartPaid
     */
    public function paid(): CartPaid
    {
        return $this->paid;
    }

    /**
     * @return CartTotalItems
     */
    public function totalItems(): CartTotalItems
    {
        return $this->totalItems;
    }

    /**
     * @return CartTotal
     */
    public function total(): CartTotal
    {
        return $this->total;
    }

    /**
     * @return CartDate
     */
    public function date(): CartDate
    {
        return $this->date;
    }

    /**
     * @return void
     */
    public function pay(): void
    {
        $this->paid = new CartPaid(true);
    }

    /**
     * @param float $price
     * @return void
     */
    public function totalsIncrement(float $price) : void {
        $this->totalItems = new CartTotalItems($this->totalItems->value()+1);
        $this->total = new CartTotal($this->total->value() + $price);
    }

    /**
     * @param float $price
     * @return void
     */
    public function totalsDecrement(float $price) : void {
        $this->totalItems = new CartTotalItems($this->totalItems->value()-1);
        $this->total = new CartTotal($this->total->value() - $price);
    }

    /**
     * @param CartTotalItems $totalItems
     * @param CartTotal $cartTotal
     * @return void
     */
    public function totalsUpdater(CartTotalItems $totalItems, CartTotal $cartTotal) : void {
        $this->totalItems =$totalItems;
        $this->total = $cartTotal;
    }
}
