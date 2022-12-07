<?php

namespace EwertonDaniel\PayPal\PurchaseUnit;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

class Item
{
    protected string $name;
    protected int $quantity;
    protected string $category;
    protected string $description;
    protected string $sku;
    protected array $unit_amount;
    protected array $item_total;
    protected array $discount;

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $quantity
     * @return Item
     * @throws ValidationException
     */
    public function setQuantity(int $quantity): static
    {
        if ($quantity > 10) {
            throw new ValidationException('The quantity must be equal or less than 10');
        }
        $this->quantity = $quantity;
        return $this;
    }

    public function setUnitAmount(string $currency_code, int $value): static
    {
        $value = round($value / 100, 2);
        $this->unit_amount = [
            'currency_code' => $currency_code,
            'value' => $value
        ];
        return $this;
    }

    public function setDiscount(string $currency_code, int $value): static
    {
        $this->discount = [
            'currency_code' => $currency_code,
            'value' => $value
        ];
        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function setCategory(string $category): static
    {
        if (!in_array(strtoupper($category), ['DIGITAL_GOODS', 'PHYSICAL_GOODS', 'DONATION'])) {
            throw new ValidationException('This is not a valid category! Valid categories: DIGITAL_GOODS, PHYSICAL_GOODS, DONATION');
        }
        $this->category = $category;
        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = substr($description, 0, 127);
        return $this;
    }

    public function setSku(string $sku): static
    {
        $this->sku = substr($sku, 0, 127);
        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}