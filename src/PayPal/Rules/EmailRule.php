<?php

namespace EwertonDaniel\PayPal\Rules;

use EwertonDaniel\PayPal\Exceptions\EmailValidationException;

class EmailRule
{
    /**
     * @throws EmailValidationException
     */
    public function __construct(private string $email)
    {
        $this->__init__();
    }

    /**
     * @throws EmailValidationException
     */
    private function __init__(): void
    {
        $this->__stringToLower();
        $this->__validate();
    }

    private function __stringToLower(): void
    {
        $this->email = strtolower($this->email);
    }

    /**
     * @throws EmailValidationException
     */
    private function __validate(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidationException("Entered value is not a valid email", 400);
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}