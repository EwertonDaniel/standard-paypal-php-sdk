<?php

namespace EwertonDaniel\PayPal\PaymentSource;

use EwertonDaniel\PayPal\Exceptions\ValidationException;

class ExperienceContext
{
    /**
     * @var string
     * The label that overrides the business name in the PayPal account on the PayPal site.
     * The pattern is defined by an external party and supports Unicode.
     */
    protected string $brand_name;
    /**
     * @var string
     *The URL where the customer is redirected after the customer cancels the payment.
     */
    protected string $cancel_url;
    /**
     * @var string
     * The BCP 47-formatted locale of pages that the PayPal payment experience shows.
     * PayPal supports a five-character code.
     * For example, da-DK, he-IL, id-ID, ja-JP, no-NO, pt-BR, ru-RU, sv-SE, th-TH, zh-CN, zh-HK, or zh-TW.
     */
    protected string $locale;
    /**
     * @var string
     * The URL where the customer is redirected after the customer approves the payment.
     */
    protected string $return_url;

    /**
     * @var string
     * The location from which the shipping address is derived.
     * The possible values are:
     *  GET_FROM_FILE. Get the customer-provided shipping address on the PayPal site.
     *
     *  NO_SHIPPING. Redacts the shipping address from the PayPal site.
     *      Recommended for digital goods.
     *
     *  SET_PROVIDED_ADDRESS. Get the merchant-provided address.
     *          The customer cannot change this address on the PayPal site.
     *      If merchant does not pass an address, customer can choose the address on PayPal pa
     */
    protected string $shipping_preference = 'NO_SHIPPING';

    /**
     * @var string
     * The URL of the merchant's logo.
     */
    protected string $logo_url;


    /**
     * @var string
     *
     * Configures a Continue or Pay Now checkout flow.
     * The possible values are:
     *  CONTINUE. After you redirect the customer to the PayPal payment page, a Continue button appears.
     *      Use this option when the final amount is not known when the checkout flow is initiated and you want to redirect the customer to the merchant page without processing the payment.
     *  PAY_NOW. After you redirect the customer to the PayPal payment page, a Pay Now button appears.
     *      Use this option when the final amount is known when the checkout is initiated and you want to process the payment immediately when the customer clicks Pay Now.
     */
    protected string $user_action;
    /**
     * @var string
     * The merchant-preferred payment methods.
     * The possible values are:
     *  UNRESTRICTED. Accepts any type of payment from the customer.
     *  IMMEDIATE_PAYMENT_REQUIRED. Accepts only immediate payment from the customer.
     *      For example, credit card, PayPal balance, or instant ACH.
     *      Ensures that at the time of capture, the payment does not have the `pending` status.
     */
    protected string $payment_method_preference;
    /**
     * @var string
     * The type of landing page to show on the PayPal site for customer checkout.
     * The possible values are:
     *  LOGIN. When the customer clicks PayPal Checkout, the customer is redirected to a page to log in to PayPal and approve the payment.
     *  GUEST_CHECKOUT. When the customer clicks PayPal Checkout, the customer is redirected to a page to enter credit or debit card and other relevant billing information required to complete the purchase. This option has previously been also called as 'BILLING'
     *  NO_PREFERENCE. When the customer clicks PayPal Checkout, the customer is redirected to either a page to log in to PayPal and approve the payment or to a page to enter credit or debit card and other relevant billing information required to complete the purchase, depending on their previous interaction with PayPal.
     */
    protected string $landing_page;
    protected string $notify_url;


    /**
     * @param string $brand_name
     * @return ExperienceContext
     */
    public function setBrandName(string $brand_name): static
    {
        $this->brand_name = $brand_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrandName(): string|null
    {
        return $this->brand_name ?? null;
    }

    /**
     * @param string $cancel_url
     * @return ExperienceContext
     */
    public function setCancelUrl(string $cancel_url): static
    {
        $this->cancel_url = $cancel_url;
        return $this;
    }

    /**
     * @param string $notify_url
     * @return ExperienceContext
     */
    public function setNotificationUrl(string $notify_url): static
    {
        $this->notify_url = $notify_url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCancelUrl(): string|null
    {
        return $this->cancel_url ?? null;
    }

    /**
     * @return string|null
     */
    public function getNotificationUrl(): string|null
    {
        return $this->notify_url ?? null;
    }

    /**
     * @param string $locale
     * @return ExperienceContext
     */
    public function setLocale(string $locale): static
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocale(): string|null
    {
        return $this->locale ?? null;
    }

    /**
     * @param string $return_url
     * @return ExperienceContext
     */
    public function setReturnUrl(string $return_url): static
    {
        $this->return_url = $return_url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnUrl(): string|null
    {
        return $this->return_url ?? null;
    }

    /**
     * @param string $shipping_preference
     * @return ExperienceContext
     */
    public function setShippingPreference(string $shipping_preference): static
    {
        $this->shipping_preference = $shipping_preference;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingPreference(): string
    {
        return $this->shipping_preference;
    }

    /**
     * @param string $logo_url
     * @return ExperienceContext
     */
    public function setLogoUrl(string $logo_url): static
    {
        $this->logo_url = $logo_url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogoUrl(): string|null
    {
        return $this->logo_url ?? null;
    }

    /**
     * @param string $landing_page
     * @return ExperienceContext
     * @throws ValidationException
     */
    public function setLandingPage(string $landing_page): static
    {
        if (!in_array(strtoupper($landing_page), ['LOGIN', 'GUEST_CHECKOUT', 'NO_PREFERENCE'])) {
            throw new ValidationException('Entered landing page is not valid! Valid values: LOGIN, GUEST_CHECKOUT, NO_PREFERENCE');
        }
        $this->landing_page = $landing_page;
        return $this;
    }

    /**
     * @return string
     */
    public function getLandingPage(): string
    {
        return $this->landing_page;
    }

    /**
     * @param string $user_action
     * @return ExperienceContext
     * @throws ValidationException
     */
    public function setUserAction(string $user_action): static
    {
        if (!in_array(strtoupper($user_action), ['CONTINUE', 'PAY_NOW'])) {
            throw new ValidationException('Entered user action preference is not valid! Valid values: CONTINUE, PAY_NOW');
        }
        $this->user_action = $user_action;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAction(): string
    {
        return $this->user_action;
    }

    /**
     * @param string $payment_method_preference
     * @return ExperienceContext
     * @throws ValidationException
     */
    public function setPaymentMethodPreference(string $payment_method_preference): static
    {
        if (!in_array(strtoupper($payment_method_preference), ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'])) {
            throw new ValidationException('Entered payment method preference is not valid! Valid values: UNRESTRICTED, IMMEDIATE_PAYMENT_REQUIRED');
        }
        $this->payment_method_preference = $payment_method_preference;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentMethodPreference(): string
    {
        return $this->payment_method_preference;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}