<?php

namespace EwertonDaniel\PayPal\PurchaseUnit;

use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PurchaseUnit\Item\Category;
use EwertonDaniel\PayPal\PurchaseUnit\Item\Quantity;
use GuzzleHttp\Utils;

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
        $this->quantity = (new Quantity($quantity))->get();
        return $this;
    }

    public function setUnitAmount(string $currency_code, int $value): static
    {
        $this->unit_amount = (new UnitAmount($currency_code, $value))->toArray();
        return $this;
    }

    public function setDiscount(string $currency_code, int $value): static
    {
        $this->discount = (new UnitAmount($currency_code, $value))->toArray();
        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function setCategory(string $category): static
    {
        $this->category = (new Category($category))->get();
        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = substr($description, 0, 127);
        return $this;
    }

    public function setSku(string $sku): static
    {
        $this->sku = substr($sku, 0, 10);
        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}