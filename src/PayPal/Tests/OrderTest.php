<?php

namespace EwertonDaniel\PayPal\Tests;

use EwertonDaniel\PayPal\Auth;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\Order;
use EwertonDaniel\PayPal\PurchaseUnit\Item;
use EwertonDaniel\PayPal\Traits\DisplayColor;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class OrderTest extends TestCase
{
    use DisplayColor;

    const RETURN_URL = 'https://example.com/returnUrl';
    const CANCEL_URL = 'https://example.com/cancelUrl';
    const NOTIFY_URL = 'https://example.com/notifyUrl';
    protected Auth $auth;
    const CLIENT_ID = '#';
    const CLIENT_SECRET = '#';

    function setUp(): void
    {
        $this->auth = new Auth(self::CLIENT_ID, self::CLIENT_SECRET, false);
        $this->order = new Order($this->auth);
    }

    function testAutoPaypalRequestId(): void
    {
        $paypal_request_id = $this->order->setPaypalRequestId()
            ->getPaypalRequestId();
        print $this->success('Auto PayPal Request ID => OK');
        print $this->information($paypal_request_id, true);
        $this->assertTrue(Uuid::isValid($paypal_request_id));
    }

    function testPaypalRequestIdSetter(): void
    {
        $paypal_request_id = $this->order->setPaypalRequestId(Uuid::uuid4())
            ->getPaypalRequestId();
        print $this->success('PayPal Request ID Setter => OK');
        print $this->information($paypal_request_id, true);
        $this->assertTrue(Uuid::isValid($paypal_request_id));
    }

    function testDefaultReturnType(): void
    {
        $return_type = $this->order->getReturnType();
        if ($return_type) {
            print $this->success('Default Return Type => OK');
            print $this->information($return_type, true);
        }
        $this->assertEquals('representation', $return_type);
    }

    function testReturnTypeSetter(): void
    {
        $return_type = $this->order->setReturnType('minimal')->getReturnType();
        if ($return_type) {
            print $this->success('Return Type Setter => OK');
            print $this->information($return_type, true);
        }
        $this->assertEquals('minimal', $return_type);
    }

    /**
     * @throws ValidationException
     */
    function testIntentSetter(): void
    {
        $intent = $this->order->setIntent('AUTHORIZE')->getIntent();
        if ($intent) {
            print $this->success('Return Type Setter => OK');
            print $this->information($intent, true);
        }
        $this->assertEquals('AUTHORIZE', $intent);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    function testPurchaseUnit(): void
    {
        $value = random_int(19900, 29900);
        $item = (new Item())->setName('Blacksaber')
            ->setQuantity(1)
            ->setUnitAmount('BRL', $value);
        $purchase_unit = $this->order->purchaseUnit()
            ->setReferenceId()
            ->addItem($item)
            ->setDescription('I can write up to one hundred and twenty seven characters as a testDescription description...')
            ->setCurrencyCode('USD')
            ->setValue($value)
            ->toArray();
        if (!empty($purchase_unit)) {
            print $this->success('Purchase Unit => OK');
            print_r($purchase_unit);
        }
        $this->assertIsArray($purchase_unit);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    function testPaymentSource(): void
    {
        $payment_source = $this->order->paymentSource()
            ->paypal()
            ->experienceContext()
            ->setPaymentMethodPreference('IMMEDIATE_PAYMENT_REQUIRED')
            ->setBrandName(' Bounty Hunters\' Guild (BHG)')
            ->setLocale('en-US')
            ->setLandingPage('NO_PREFERENCE')
            ->setShippingPreference('NO_SHIPPING')
            ->setUserAction('PAY_NOW'
            )->setReturnUrl(self::RETURN_URL)
            ->toArray();
        if (!empty($payment_source)) {
            print $this->success('Payment Source => OK');
            print_r($payment_source);
        }
        $this->assertIsArray($payment_source);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     * @throws GuzzleException
     */
    function testCreateOrder(): void
    {

        $value = random_int(19900, 29900);
        $item = (new Item())->setName('Blacksaber Mandalore')
            ->setQuantity(1)
            ->setUnitAmount('BRL', $value);
        $this->order
            ->setPaypalRequestId()
            ->setIntent('CAPTURE')
            ->purchaseUnit()
            ->addItem($item)
            ->setReferenceId()
            ->setDescription('I can write up to one hundred and twenty seven characters as a testDescription description...')
            ->setCurrencyCode('BRL')
            ->setValue($value);
        $this->order->pushPurchaseUnit()
            ->paymentSource()
            ->paypal()
            ->experienceContext()
            ->setPaymentMethodPreference('IMMEDIATE_PAYMENT_REQUIRED')
            ->setBrandName(' Bounty Hunters Guild (BHG)')
            ->setLocale('pt-BR')
            ->setLandingPage('LOGIN')
            ->setShippingPreference('NO_SHIPPING')
            ->setUserAction('PAY_NOW')
            ->setReturnUrl(self::RETURN_URL);
        $response = $this->order->create();
        if (!empty($response)) {
            print $this->success('Order Creation => OK');
            print $this->information('ID: ' . $response['id']);
            print $this->information('Status: ' . $response['status']);
            print $this->information('Self Url: ' . $response['links']['self']['url']);
            print $this->information('Payer Action: ' . $response['links']['payer_action']['url']);
        }
        $this->assertIsArray($response);
    }
}