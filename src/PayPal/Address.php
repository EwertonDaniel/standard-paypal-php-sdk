<?php

namespace EwertonDaniel\PayPal;

use GuzzleHttp\Utils;

class Address
{
    protected string $address_line_1;
    protected string $address_line_2;
    protected string $admin_area_1;
    protected string $admin_area_2;
    protected string $postal_code;
    protected string $country_code;

    public function setLineOne(string $address_line_1): static
    {
        $this->address_line_1 = $address_line_1;
        return $this;
    }

    public function setLineTwo(string $address_line_2): static
    {
        $this->address_line_2 = $address_line_2;
        return $this;
    }

    public function setAdminAreaOne(string $admin_area_1): static
    {
        $this->admin_area_1 = $admin_area_1;
        return $this;
    }

    public function setAdminAreaTwo(string $admin_area_2): static
    {
        $this->admin_area_2 = $admin_area_2;
        return $this;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    public function setCountryCode(string $country_code): static
    {
        $this->country_code = strtoupper($country_code);
        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}