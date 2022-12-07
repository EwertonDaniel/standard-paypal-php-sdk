<?php

namespace EwertonDaniel\PayPal\PaymentSource\ExperienceContext;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

/**
 * @note The location from which the shipping address is derived.
 * The possible values are:
 *  GET_FROM_FILE. Get the customer-provided shipping address on the PayPal site.
 *
 *  NO_SHIPPING. Redacts the shipping address from the PayPal site.
 *      Recommended for digital goods.
 *
 *  SET_PROVIDED_ADDRESS. Get the merchant-provided address.
 *          The customer cannot change this address on the PayPal site.
 */
class ShippingPreference
{
    const SHIPPING_PREFERENCE = ['GET_FROM_FILE', 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS'];
    const ERROR_MESSAGE = "Entered shipping preference is not valid! Valid values: ['GET_FROM_FILE','NO_SHIPPING' ,'SET_PROVIDED_ADDRESS']";

    /**
     * @throws ValidationException
     */
    public function __construct(private string $shipping_preference)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->shipping_preference = strtoupper($this->shipping_preference);
        if (!in_array(strtoupper($this->shipping_preference), self::SHIPPING_PREFERENCE)) {
            throw new ValidationException(self::ERROR_MESSAGE);
        }
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->shipping_preference;
    }
}