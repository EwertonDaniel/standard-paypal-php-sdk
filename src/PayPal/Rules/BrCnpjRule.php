<?php

/**
 * This a class is to validate the Brazilian  Document CNPJ (National Register of Legal Entities).
 *
 * @author Ewerton Daniel<ewertondaniel@icloud.com>
 *
 */

namespace EwertonDaniel\PayPal\Rules;

use EwertonDaniel\PayPal\Exceptions\BrCnpjValidationException;

class BrCnpjRule
{

    const CNPJ_MASK_PATTERN = "##.###.###/##-##";

    /**
     * @throws BrCnpjValidationException
     */
    public function __construct(private string $cnpj)
    {
        $this->__init__();
    }

    /**
     * @throws BrCnpjValidationException
     * Automatically start functions
     */
    private function __init__(): void
    {
        $this->__clear();
        $this->__checkLength();
        $this->__checkSequentialValues();
        $this->__checkFirstVerifierDigit();
        $this->__checkSecondVerifierDigit();
    }

    /**
     * @return void
     * Clears the value leaving only numbers
     */
    private function __clear(): void
    {
        $this->cnpj = preg_replace('/[^0-9]/is', '', $this->cnpj);
    }

    /**
     * @throws BrCnpjValidationException
     * Checks if the value has the length of a valid CPF
     */
    private function __checkLength(): void
    {
        $length = strlen($this->cnpj);
        if ($length !== 14) {
            $message = "Entered value doesn't correspond to a valid CNPJ. ($length characters total: $this->cnpj).";
            $this->throwsCnpjException($message);
        }
    }

    /**
     * @throws BrCnpjValidationException
     * Check if the value are sequential numbers
     */
    private function __checkSequentialValues(): void
    {
        if (preg_match('/^(\d)\1{13}/', $this->cnpj)) {
            $length = strlen($this->cnpj);
            $message = "Entered value doesn't correspond to a valid CPF. (The number {$this->cnpj[0]}  is repeated $length times).";
            $this->throwsCnpjException($message);
        }
    }


    /**
     * @throws BrCnpjValidationException
     */
    private function __checkFirstVerifierDigit(): void
    {
        for ($c = 0, $n = 5, $sum = 0; $c < 12; $c++) {
            $sum += $this->cnpj[$c] * $n;
            $n = ($n == 2) ? 9 : $n - 1;
        }
        $mod = $sum % 11;

        if ($this->cnpj[12] != ($mod < 2 ? 0 : 11 - $mod)) {
            $this->throwsCnpjException('First verifier digit is invalid');
        }
    }

    /**
     * @throws BrCnpjValidationException
     */
    private function __checkSecondVerifierDigit(): void
    {
        for ($c = 0, $n = 6, $sum = 0; $c < 13; $c++) {
            $sum += $this->cnpj[$c] * $n;
            $n = ($n == 2) ? 9 : $n - 1;
        }

        $mod = $sum % 11;

        if (!$this->cnpj[13] == ($mod < 2 ? 0 : 11 - $mod)) {
            $this->throwsCnpjException('Second verifier digit is invalid');
        }
    }

    private function mask(): string
    {
        $mask = self::CNPJ_MASK_PATTERN;
        $str = str_replace(" ", "", $this->cnpj);
        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }

    /**
     * @return string
     * return in default cnpj format mask value
     */
    public function getCnpjMasked(): string
    {
        return $this->mask();
    }

    /**
     * @return string
     * return only cnpj numbers value
     */
    public function getCnpjClean(): string
    {
        return $this->cnpj;
    }

    /**
     * @throws BrCnpjValidationException
     */
    private function throwsCnpjException($message): void
    {
        throw new BrCnpjValidationException($message, 400);
    }
}