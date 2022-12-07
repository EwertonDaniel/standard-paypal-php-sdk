<?php

namespace EwertonDaniel\PayPal\Traits\Order;

use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PurchaseUnit;

trait OrderGetters
{
    /**
     * @return string|null
     */
    public function getPaypalRequestId(): string|null
    {
        if (!isset($this->paypal_request_id)) {
            $this->setPaypalRequestId();
        }
        return $this->paypal_request_id ?? null;
    }

    /**
     * @throws ValidationException
     */
    public function getIntent(): string
    {
        return $this->intent ?? throw new ValidationException('The intent variable has not been initialized!');
    }

    /**
     * @param bool $class
     * @return array|PurchaseUnit
     * @throws ValidationException
     */
    public function getPurchaseUnit(bool $class = false): PurchaseUnit|array
    {
        $purchase_unit = is_array($this->purchase_unit) ? $this->purchase_unit : ($class ? $this->purchase_unit : $this->purchase_unit->toArray());
        return !empty($purchase_unit) ? $purchase_unit : throw new ValidationException('The purchase unit is empty');
    }

    public function getPurchaseUnits(): array
    {
        return $this->purchase_units;
    }

    public function getReturnType(): string
    {
        return $this->return_type ?? 'representation';
    }

    /**
     * @throws ValidationException
     */
    public function getUrl(): string
    {
        return $this->url ?? throw new ValidationException('The url variable has not been initialized!');
    }
}