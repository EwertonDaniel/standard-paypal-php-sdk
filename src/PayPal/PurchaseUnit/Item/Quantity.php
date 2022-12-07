<?php

namespace EwertonDaniel\PayPal\PurchaseUnit\Item;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

class Quantity
{
    /**
     * @throws ValidationException
     */
    public function __construct(private readonly int $quantity)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        if ($this->quantity > 10) {
            throw new ValidationException('The quantity must be equal or less than 10');
        }
    }

    public function get(): int
    {
        return $this->quantity;
    }
}