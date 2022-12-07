<?php

namespace EwertonDaniel\PayPal\PaymentSource;

use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PhoneNumber;
use EwertonDaniel\PayPal\Traits\PaymentSource\PayPalPaymentSourceGetters;
use EwertonDaniel\PayPal\Traits\PaymentSource\PayPalPaymentSourceSetters;

class PaypalPaymentSource
{
    use PayPalPaymentSourceSetters, PayPalPaymentSourceGetters;

    /**
     * @throws ValidationException
     */
    public function phoneNumber(string $country_code, string $national_number, string $extension_number): static
    {
        $phone_number = new PhoneNumber();
        $this->phone_number = $phone_number->setCountryCode($country_code)->setNationalNumber($national_number)->setExtensionNumber($extension_number)->toArray();
        return $this;
    }

    public function experienceContext(): ExperienceContext
    {
        $this->experience_context = new ExperienceContext();
        return $this->experience_context;
    }

    public function toArray(): array
    {
        if (!is_array($this->experience_context)) {
            $this->experience_context = $this->experience_context->toArray();
        }
        return get_object_vars($this);
    }
}