<?php

namespace EwertonDaniel\PayPal\PaymentSource\ExperienceContext;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

/**
 * @note
 * Configures a Continue or Pay Now checkout flow.
 * The possible values are:
 *  CONTINUE. After you redirect the customer to the PayPal payment page, a Continue button appears.
 *      Use this option when the final amount is not known when the checkout flow is initiated, and you want to redirect the customer to the merchant page without processing the payment.
 *  PAY_NOW. After you redirect the customer to the PayPal payment page, a Pay Now button appears.
 *      Use this option when the final amount is known when the checkout is initiated, and you want to process the payment immediately when the customer clicks Pay Now.
 */
class UserAction
{
    const USER_ACTION = ['CONTINUE', 'PAY_NOW'];
    const ERROR_MESSAGE = "Entered user action preference is not valid! Valid values: ['CONTINUE', 'PAY_NOW']";

    /**
     * @throws ValidationException
     */
    public function __construct(private string $user_action)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->user_action = strtoupper($this->user_action);
        if (!in_array(strtoupper($this->user_action), self::USER_ACTION)) {
            throw new ValidationException(self::ERROR_MESSAGE);
        }
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->user_action;
    }
}