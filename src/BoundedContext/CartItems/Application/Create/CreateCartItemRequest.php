<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\CartItems\Application\Create;

use Illuminate\Http\Request;

final class CreateCartItemRequest
{
    private string $id;
    private string $cartId;
    private string $productId;
    private string $name;
    private string $description;
    private float $price;

    /**
     * @param string $id
     * @param string $cartId
     * @param Request $request
     */
    public function __construct(string $id, string $cartId, Request $request)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->productId = $request->get('productId');
        $this->name = $request->get('name');
        $this->description = $request->get('description');
        $this->price = $request->float('price');
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
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
    }
}
