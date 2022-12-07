<?php

namespace EwertonDaniel\PayPal\PurchaseUnit\Item;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

/**
 * @note The item category type.
 *
 * The possible values are:
 *  DIGITAL_GOODS. Goods that are stored, delivered, and used in their electronic format.
 *      This value is not currently supported for API callers that leverage the PayPal for Commerce Platform product.
 *  PHYSICAL_GOODS. A tangible item that can be shipped with proof of delivery.
 *  DONATION. A contribution or gift for which no good or service is exchanged, usually to a not for profit organization.
 *
 */
class Category
{
    const CATEGORIES = ['DIGITAL_GOODS', 'PHYSICAL_GOODS', 'DONATION'];

    /**
     * @throws ValidationException
     */
    public function __construct(private string $category)
    {
        $this->__validate();
    }

    /**
     * @throws ValidationException
     */
    private function __validate(): void
    {
        $this->category = strtoupper($this->category);
        if (!in_array(strtoupper($this->category), self::CATEGORIES)) {
            throw new ValidationException('This is not a valid category! Valid categories: DIGITAL_GOODS, PHYSICAL_GOODS, DONATION');
        }
    }

    public function get(): string
    {
        return $this->category;
    }
}