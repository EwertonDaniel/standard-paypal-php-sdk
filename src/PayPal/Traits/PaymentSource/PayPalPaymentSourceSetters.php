<?php

namespace EwertonDaniel\PayPal\Traits\PaymentSource;

use EwertonDaniel\PayPal\Address;
use EwertonDaniel\PayPal\Exceptions\BrCnpjValidationException;
use EwertonDaniel\PayPal\Exceptions\BrCpfValidationException;
use EwertonDaniel\PayPal\Exceptions\EmailValidationException;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext;
use EwertonDaniel\PayPal\PaymentSource\PaypalPaymentSource;
use EwertonDaniel\PayPal\PhoneNumber;
use EwertonDaniel\PayPal\Rules\EmailRule;
use EwertonDaniel\PayPal\TaxInfo;

trait PayPalPaymentSourceSetters
{
    /**
     * @var string
     * The PayPal-assigned ID for the PayPal account holder.
     * Pattern: ^[2-9A-HJ-NP-Z]{13}$.
     */
    protected string $account_id;
    protected Address|array $address;

    /**
     * @var string
     * The birthdate of the PayPal account holder in YYYY-MM-DD format.
     * Pattern: ^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$.
     */
    protected string $birth_date;

    /**
     * @var string
     * The email address of the PayPal account holder.
     */
    protected string $email_address;
    /**
     * @var array
     * The name of the PayPal account holder.
     * Supports only the given_name and surname properties.
     */
    protected array $name;

    protected array $phone_number;
    /**
     * @var string
     * The possible values are:
     *    FAX. A fax machine.
     *    HOME. A home phone.
     *    MOBILE. A mobile phone.
     *    OTHER. Other.
     *    PAGER. A pager.
     *    WORK. A work phone.
     */
    protected string $phone_type;

    /**
     * @var array
     * The tax information of the PayPal account holder.
     * Required only for Brazilian PayPal account holder's.
     * Both tax_id and tax_id_type are required.
     */
    protected array $tax_info;
    /**
     * @var ExperienceContext|array
     * Customizes the payer experience during the approval process for the payment.
     */
    protected ExperienceContext|array $experience_context;

    /**
     * @param string $account_id
     */
    public function setAccountId(string $account_id): void
    {
        $this->account_id = $account_id;
    }

    /**
     * @param Address $address
     * @return PaypalPaymentSource
     */
    public function setAddress(Address $address): static
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @param string $email_address
     * @throws EmailValidationException
     */
    public function setEmailAddress(string $email_address): void
    {
        $this->email_address = (new EmailRule($email_address))->getEmail();
    }

    /**
     * @param string $given_name
     * @param string $surname
     * @return PayPalPaymentSourceSetters
     */
    public function setName(string $given_name, string $surname): static
    {
        $this->name = [
            'given_name' => $given_name,
            'surname' => $surname
        ];
        return $this;
    }

    /**
     * @param array|PhoneNumber $phone_number
     */
    public function setPhoneNumber(PhoneNumber|array $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @param string $phone_type
     * @throws ValidationException
     */
    public function setPhoneType(string $phone_type): void
    {
        if (!in_array($phone_type, ['FAX', 'HOME', 'MOBILE', 'OTHER', 'PAGER', 'WORK'])) {
            throw new ValidationException('Entered pgone type is not a vild type! Valid Types: FAX, HOME, MOBILE, OTHER, PAGER, WORK');
        }
        $this->phone_type = $phone_type;
    }

    /**
     * @param string $tx_id
     * @param string $tx_id_type
     * @return PayPalPaymentSourceSetters
     * @throws BrCnpjValidationException
     * @throws BrCpfValidationException
     * @throws ValidationException
     */
    public function setTaxInfo(string $tx_id, string $tx_id_type): static
    {
        $this->tax_info = (new TaxInfo($tx_id, $tx_id_type))->toArray();
        return $this;
    }

    public function setExperienceContext(ExperienceContext $experience_context): static
    {
        $this->experience_context = $experience_context->toArray();
        return $this;
    }
}