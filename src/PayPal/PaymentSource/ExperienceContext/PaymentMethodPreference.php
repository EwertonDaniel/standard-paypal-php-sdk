<?php

namespace EwertonDaniel\PayPal\PaymentSource\ExperienceContext;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

/**
 * @note The merchant-preferred payment methods.
 * The possible values are:
 *  UNRESTRICTED. Accepts any type of payment from the customer.
 *  IMMEDIATE_PAYMENT_REQUIRED. Accepts only immediate payment from the customer.
 *      For example, credit card, PayPal balance, or instant ACH.
 *      Ensures that at the time of capture, the payment does not have the `pending` status.
 */
class PaymentMethodPreference
{
    const PAYMENT_METHOD_PREFERENCE = ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'];
    const ERROR_MESSAGE = "Entered payment method preference is not valid! Valid values: ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED']";

    /**
     * @throws ValidationException
     */
    public function __construct(private string $payment_method_preference)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->payment_method_preference = strtoupper($this->payment_method_preference);
        if (!in_array(strtoupper($this->payment_method_preference), self::PAYMENT_METHOD_PREFERENCE)) {
            throw new ValidationException(self::ERROR_MESSAGE);
        }
    }

    public function get(): string
    {
        return $this->payment_method_preference;
    }
}