<?php

namespace EwertonDaniel\PayPal\PurchaseUnit;

class Payee
{
    public function __construct(private readonly string $email_address, private readonly string $merchant_id)
    {

    }

    public function toArray(): array
    {
        return [
            'email_address' => $this->email_address,
            'merchant_id' => $this->merchant_id
        ];
    }
}