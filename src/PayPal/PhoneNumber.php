<?php

namespace EwertonDaniel\PayPal;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

class PhoneNumber
{
    /**
     * @var string
     * The country calling code (CC), in its canonical international E.164 numbering plan format.
     * @link https://www.itu.int/rec/T-REC-E.164/en
     * The combined length of the CC and the national number must not be greater than 15 digits.
     * The national number consists of a national destination code (NDC) and subscriber number (SN).
     */
    protected string $country_code;
    /**
     * @var string
     * The national number, in its canonical international E.164 numbering plan format.
     * @link https://www.itu.int/rec/T-REC-E.164/en
     * The combined length of the country calling code (CC) and the national number must not be greater than 15 digits.
     * The national number consists of a national destination code (NDC) and subscriber number (SN).
     */
    protected string $national_number;
    /**
     * @var string
     * The extension number.
     */
    protected string $extension_number;

    /**
     * @param string $country_code
     * @return PhoneNumber
     * @throws ValidationException
     */
    public function setCountryCode(string $country_code): static
    {
        if (strlen($country_code) > 3) {
            throw new ValidationException('The country calling code length max is 3 characteres!');
        }
        $this->country_code = $country_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param string $national_number
     * @return PhoneNumber
     */
    public function setNationalNumber(string $national_number): static
    {
        $this->national_number = $national_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getNationalNumber(): string
    {
        return $this->national_number;
    }

    /**
     * @param string $extension_number
     * @return PhoneNumber
     */
    public function setExtensionNumber(string $extension_number): static
    {
        $this->extension_number = $extension_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtensionNumber(): string
    {
        return $this->extension_number;
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}