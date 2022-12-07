<?php

namespace EwertonDaniel\PayPal;

use EwertonDaniel\PayPal\PaymentSource\PaypalPaymentSource;
use GuzzleHttp\Utils;

class PaymentSource
{
    protected array|PaypalPaymentSource $paypal;

    public function paypal(): PaypalPaymentSource
    {
        return $this->paypal = new PaypalPaymentSource();
    }

    /**
     * @param PaypalPaymentSource $paypal
     * @return PaymentSource
     */
    public function setPaypal(PaypalPaymentSource $paypal): static
    {
        $this->paypal = $paypal;
        return $this;
    }

    /**
     * @param bool $class
     * @return array|PaypalPaymentSource
     */
    public function getPaypal(bool $class = false): PaypalPaymentSource|array
    {
        return is_array($this->paypal) ? $this->paypal : ($class ? $this->paypal : $this->paypal->toArray());
    }

    public function toArray(): array
    {
        if (isset($this->paypal) && !is_array($this->paypal)) {
            $this->paypal = $this->paypal->toArray();
        }
        return get_object_vars($this);
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}