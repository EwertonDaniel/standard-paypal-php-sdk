<?php

namespace EwertonDaniel\PayPal\PaymentSource\ExperienceContext;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

/**
 * @note The type of landing page to show on the PayPal site for customer checkout.
 * The possible values are:
 *  LOGIN. When the customer clicks PayPal Checkout, the customer is redirected to a page to log in to PayPal and approve the payment.
 *  GUEST_CHECKOUT. When the customer clicks PayPal Checkout, the customer is redirected to a page to enter credit or debit card and other relevant billing information required to complete the purchase. This option has previously been also called as 'BILLING'
 *  NO_PREFERENCE. When the customer clicks PayPal Checkout, the customer is redirected to either a page to log in to PayPal and approve the payment or to a page to enter credit or debit card and other relevant billing information required to complete the purchase, depending on their previous interaction with PayPal.
 */
class LandingPage
{
    const LANDING_PAGE = ['LOGIN', 'GUEST_CHECKOUT', 'NO_PREFERENCE'];
    const ERROR_MESSAGE = "Entered landing page is not valid! Valid values: ['LOGIN', 'GUEST_CHECKOUT', 'NO_PREFERENCE']";

    /**
     * @throws ValidationException
     */
    public function __construct(private string $landing_page)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->landing_page = strtoupper($this->landing_page);
        if (!in_array(strtoupper($this->landing_page), self::LANDING_PAGE)) {
            throw new ValidationException(self::ERROR_MESSAGE);
        }
    }

    public function get(): string
    {
        return $this->landing_page;
    }
}