<?php

namespace EwertonDaniel\PayPal\Traits\PaymentSource;

use EwertonDaniel\PayPal\Address;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext;
use EwertonDaniel\PayPal\PhoneNumber;

trait PayPalPaymentSourceGetters
{
    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->account_id;
    }

    /**
     * @return Address
     */
    public function address(): Address
    {
        $this->address = new Address();
        return $this->address;
    }

    /**
     * @param bool $class
     * @return array|Address
     */
    public function getAddress(bool $class = false): Address|array
    {
        return is_array($this->address) ? $this->address : (!$class ? $this->address->toArray() : $this->address);
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->email_address;
    }

    /**
     * @return array
     */
    public function getName(): array
    {
        return $this->name;
    }

    /**
     * @param bool $class
     * @return array|ExperienceContext
     */
    public function getExperienceContext(bool $class = false): array|ExperienceContext
    {
        return is_array($this->experience_context) ? $this->experience_context : ($class ? $this->experience_context : $this->experience_context->toArray());
    }

    /**
     * @return array
     */
    public function getTaxInfo(): array
    {
        return $this->tax_info;
    }

    /**
     * @return string
     */
    public function getPhoneType(): string
    {
        return $this->phone_type;
    }

    /**
     * @return array|PhoneNumber
     */
    public function getPhoneNumber(): PhoneNumber|array
    {
        return $this->phone_number;
    }

}