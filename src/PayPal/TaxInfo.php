<?php

namespace EwertonDaniel\PayPal;

use EwertonDaniel\PayPal\Exceptions\BrCnpjValidationException;
use EwertonDaniel\PayPal\Exceptions\BrCpfValidationException;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\Rules\BrCnpjRule;
use EwertonDaniel\PayPal\Rules\BrCpfRule;

class TaxInfo
{
    protected string $tx_id_type;
    protected string $tx_id;

    /**
     * @throws ValidationException
     * @throws BrCpfValidationException
     * @throws BrCnpjValidationException
     */
    public function __construct(string $tx_id, string $tx_id_type)
    {
        $this->__validate($tx_id, $tx_id_type);
    }

    /**
     * @throws ValidationException
     * @throws BrCpfValidationException
     * @throws BrCnpjValidationException
     */
    private function __validate(string $tx_id, string $tx_id_type): void
    {
        if (!in_array($tx_id_type, ['BR_CPF', 'BR_CNPJ'])) {
            throw new ValidationException('Entered TX ID Type is an invalid value!' . "Entered value:$tx_id_type");
        }
        $this->tx_id_type = $tx_id_type;
        if ($tx_id_type === 'BR_CPF') {
            $this->tx_id = (new BrCpfRule($tx_id))->getCpfClean();
        } else {
            $this->tx_id = (new BrCnpjRule($tx_id))->getCnpjClean();
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}