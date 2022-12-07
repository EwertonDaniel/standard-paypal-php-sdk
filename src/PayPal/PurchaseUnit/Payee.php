<?php

namespace EwertonDaniel\PayPal\PurchaseUnit;

use EwertonDaniel\PayPal\Exceptions\EmailValidationException;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\Rules\EmailRule;

class Payee
{
    const MERCHANT_ID_PATTERN = '/^[2-9A-HJ-NP-Z]{13}$/';
    const MERCHANT_ID_PATTERN_ERROR_MESSAGE = 'Entered merchant id is not valid pattern!';

    /**
     * @throws ValidationException
     * @throws EmailValidationException
     */
    public function __construct(private string $email_address, private readonly string $merchant_id)
    {
        $this->__validate();
    }

    /**
     * @throws EmailValidationException
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->email_address = (new EmailRule($this->email_address))->getEmail();
        if (!preg_match(self::MERCHANT_ID_PATTERN, $this->merchant_id)) {
            throw new ValidationException(self::MERCHANT_ID_PATTERN_ERROR_MESSAGE);
        }
    }

    public function toArray(): array
    {
        return [
            'email_address' => $this->email_address,
            'merchant_id' => $this->merchant_id
        ];
    }
}