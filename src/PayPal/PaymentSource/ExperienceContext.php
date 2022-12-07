<?php

namespace EwertonDaniel\PayPal\PaymentSource;

use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext\LandingPage;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext\PaymentMethodPreference;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext\ShippingPreference;
use EwertonDaniel\PayPal\PaymentSource\ExperienceContext\UserAction;
use GuzzleHttp\Utils;

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
     */
    protected string $shipping_preference = 'NO_SHIPPING';

    /**
     * @var string
     * The URL of the merchant's logo.
     */
    protected string $logo_url;

    /**
     * @var string
     */
    protected string $user_action;
    /**
     * @var string
     */
    protected string $payment_method_preference;

    /**
     * @var string
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
        $this->shipping_preference = (new ShippingPreference($shipping_preference))->get();
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
        $this->landing_page = (new LandingPage($landing_page))->get();
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
        $this->user_action = (new UserAction($user_action))->get();
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

        $this->payment_method_preference = (new PaymentMethodPreference($payment_method_preference))->get();
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

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}