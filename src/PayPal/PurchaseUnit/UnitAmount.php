<?php

namespace EwertonDaniel\PayPal\PurchaseUnit;

use GuzzleHttp\Utils;

class UnitAmount
{
    public function __construct(private string $currency_code, private int $value)
    {
        $this->__handle();
    }

    private function __handle(): void
    {
        $this->currency_code = strtoupper($this->currency_code);
        $this->value = round($this->value / 100, 2);
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