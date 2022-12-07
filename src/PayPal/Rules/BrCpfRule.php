<?php

/**
 * This a class is to validate the Brazilian  Document CPF (Individual Person Code).
 *
 * @author Ewerton Daniel<ewertondaniel@icloud.com>
 *
 */

namespace EwertonDaniel\PayPal\Rules;

use EwertonDaniel\PayPal\Exceptions\BrCpfValidationException;

class BrCpfRule
{

    const CPF_MASK_PATTERN = "###.###.###-##";

    /**
     * @throws BrCpfValidationException
     */
    public function __construct(private string $cpf)
    {
        $this->__init__();
    }

    /**
     * @throws BrCpfValidationException
     * Automatically start functions
     */
    private function __init__(): void
    {
        $this->__clear();
        $this->__checkLength();
        $this->__checkSequentialValues();
        $this->__checkIsRealDocumentCPF();
    }

    /**
     * @return void
     * Clears the value leaving only numbers
     */
    private function __clear(): void
    {
        $this->cpf = preg_replace('/[^0-9]/is', '', $this->cpf);
    }

    /**
     * @throws BrCpfValidationException
     * Checks if the value has the length of a valid CPF
     */
    private function __checkLength(): void
    {
        $length = strlen($this->cpf);
        if ($length !== 11) {
            $message = "Entered value doesn't correspond to a valid CPF. ($length characters total: $this->cpf).";
            $this->throwsCpfException($message);
        }
    }

    /**
     * @throws BrCpfValidationException
     * Check if the value are sequential numbers
     */
    private function __checkSequentialValues(): void
    {
        if (preg_match('/^(\d)\1{10}/', $this->cpf)) {
            $length = strlen($this->cpf);
            $message = "Entered value doesn't correspond to a valid CPF. (The number {$this->cpf[0]}  is repeated $length times).";
            $this->throwsCpfException($message);
        }
    }

    /**
     * @throws BrCpfValidationException
     * CPF Verifier Digit Validation Calculator
     */
    private function __checkIsRealDocumentCPF(): void
    {
        for ($e = 9; $e < 11; $e++) {
            for ($d = 0, $y = 0; $y < $e; $y++) {
                $d += $this->cpf[$y] * (($e + 1) - $y);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf[$y] != $d) {
                $message = "The entered value doesn't correspond to a valid CPF. (Entered CPF didn't pass the validation calculation)";
                $this->throwsCpfException($message);
            }
        }
    }

    private function mask(): string
    {
        $mask = self::CPF_MASK_PATTERN;
        $str = str_replace(" ", "", $this->cpf);
        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }
        return $mask;
    }

    /**
     * @return string
     * return in default cpf format mask value
     */
    public function getCpfMasked(): string
    {
        return $this->mask();
    }

    /**
     * @return string
     * return only cpf numbers value
     */
    public function getCpfClean(): string
    {
        return $this->cpf;
    }

    /**
     * @throws BrCpfValidationException
     */
    private function throwsCpfException($message): void
    {
        throw new BrCpfValidationException($message, 400);
    }
}