<?php

namespace EwertonDaniel\PayPal;

use EwertonDaniel\PayPal\Exceptions\ValidationException;
use GuzzleHttp\Utils;

class Shipping
{
    protected array|Address $address;
    protected string $name;
    protected string $type;

    public function setAddress(Address $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function address(): Address
    {
        $this->address = new Address();
        return $this->address;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function setType(string $type): static
    {
        if (!in_array($type, ['SHIPPING', 'PICKUP_IN_PERSON'])) throw new ValidationException('Entered type is invalid! Valid types: SHIPPING, PICKUP_IN_PERSON');
        $this->type = $type;
        return $this;
    }

    public function toArray(): array
    {
        $response = array('address' => is_array($this->address) ? $this->address : $this->address->toArray());
        if (isset($this->name)) {
            $response['name'] = $this->name;
        }
        if (isset($this->type)) {
            $response['type'] = $this->type;
        }
        return $response;
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}