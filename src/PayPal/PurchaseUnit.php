<?php

namespace EwertonDaniel\PayPal;

use EwertonDaniel\PayPal\Exceptions\EmailValidationException;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PurchaseUnit\Item;
use EwertonDaniel\PayPal\PurchaseUnit\Payee;
use EwertonDaniel\PayPal\PurchaseUnit\UnitAmount;
use Ramsey\Uuid\Uuid;

class PurchaseUnit
{
    protected string $reference_id;

    protected string|null $description;

    protected array $amount = array('currency_code' => 'USD',);
    protected string|null $invoice_id;

    protected array $items;

    protected array|Payee $payee;
    protected array|Shipping $shipping;
    protected string $soft_descriptor;

    public function setDescription(string $description): static
    {
        $this->description = substr($description, 0, 127);
        return $this;
    }

    public function setCurrencyCode(string $currency_code): static
    {
        $this->amount['currency_code'] = $currency_code;
        return $this;
    }

    private function setValue(): void
    {
        $value = 0.00;
        foreach ($this->items as $item) {
            $value += $item['unit_amount']['value'];
        }
        $this->amount['value'] = round($value - ($this->amount['breakdown']['discount']['value'] ?? 0), 2);
    }

    private function setBreakdownValue(): void
    {
        $this->amount['breakdown']['item_total'] = [
            'value' => $this->amount['value'] + ($this->amount['breakdown']['discount']['value'] ?? 0),
            'currency_code' => $this->amount['currency_code']
        ];
    }

    public function setDiscount(string $currency_code, int $value): static
    {
        $this->amount['breakdown']['discount'] = (new UnitAmount($currency_code, $value))->toArray();
        return $this;
    }

    public function setInvoiceId(string $invoice_id): static
    {
        $this->invoice_id = $invoice_id;
        return $this;
    }

    public function addItem(Item $item): static
    {
        $this->items[] = $item->toArray();
        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function addItemWithBasicData(string $name, int $quantity, int $value): static
    {
        $this->items[] = (new Item())
            ->setName($name)
            ->setQuantity($quantity)
            ->setUnitAmount($this->amount['currency_code'], $value)->toArray();
        return $this;
    }

    /**
     * @throws ValidationException
     * @throws EmailValidationException
     */
    public function payee(string $email_address, string $merchant_id): Payee
    {
        $this->payee = new Payee($email_address, $merchant_id);
        return $this->payee;
    }

    public function setPayee(Payee $payee): static
    {
        $this->payee = $payee->toArray();
        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function setReferenceId(string|null $reference_id = null): static
    {
        if ($reference_id && !Uuid::isValid($reference_id)) {
            throw new ValidationException("Entered reference id ($reference_id) is not an valid UUID!");
        }
        $this->reference_id = $reference_id ?? Uuid::uuid4()->toString();
        return $this;
    }

    public function shipping(): Shipping
    {
        $this->shipping = new Shipping();
        return $this->shipping;
    }

    public function setShipping(Shipping $shipping): static
    {
        $this->shipping = $shipping->toArray();
        return $this;
    }

    public function setSoftdescriptor(string $soft_descriptor): static
    {
        $this->soft_descriptor = substr($soft_descriptor, 0, 22);
        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->reference_id;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getAmount(): array
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getInvoiceId(): ?string
    {
        return $this->invoice_id;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param bool $class
     * @return array|Payee
     */
    public function getPayee(bool $class = false): array|Payee
    {
        return is_array($this->payee) ? $this->payee : (!$class ? $this->payee->toArray() : $this->payee);
    }

    /**
     * @param bool $class
     * @return array|Shipping
     */
    public function getShipping(bool $class = false): array|Shipping
    {
        return is_array($this->shipping) ? $this->shipping : (!$class ? $this->shipping->toArray() : $this->shipping);
    }

    /**
     * @return string
     */
    public function getSoftDescriptor(): string
    {
        return $this->soft_descriptor;
    }

    public function toArray(): array
    {
        $this->setValue();
        $this->setBreakdownValue();
        if (isset($this->shipping) && !is_array($this->shipping)) {
            $this->shipping = $this->shipping->toArray();
        }
        if (isset($this->payee) && !is_array($this->payee)) {
            $this->payee = $this->payee->toArray();
        }
        return get_object_vars($this);
    }

    public function toString(): string
    {
        return json_encode($this->toArray());
    }
}