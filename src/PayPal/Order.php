<?php

namespace EwertonDaniel\PayPal;

use Echosistema\SHR\Http;
use EwertonDaniel\PayPal\Configuration\Configuration;
use EwertonDaniel\PayPal\Exceptions\OrderCreationException;
use EwertonDaniel\PayPal\Exceptions\PaymentException;
use EwertonDaniel\PayPal\Exceptions\ValidationException;
use EwertonDaniel\PayPal\Traits\Order\OrderGetters;
use EwertonDaniel\PayPal\Traits\Order\OrderSetters;
use GuzzleHttp\Exception\GuzzleException;

class Order
{
    use OrderSetters, OrderGetters;

    protected null|Auth $auth;
    protected array $response;

    public function __construct(Auth|null $auth = null)
    {
        $this->auth = $auth;
        $this->__init__();
    }

    private function __init__(): void
    {
        $this->http = new Http();
        $this->configuration = new Configuration();
    }

    /**
     * @return PurchaseUnit
     */
    public function purchaseUnit(): PurchaseUnit
    {
        $this->purchase_unit = new PurchaseUnit();
        return $this->purchase_unit;
    }

    public function addPurchaseUnit(PurchaseUnit $purchase_unit): static
    {
        $this->purchase_units[] = $purchase_unit->toArray();
        return $this;
    }

    public function pushPurchaseUnit(): static
    {
        $this->purchase_units[] = $this->purchase_unit->toArray();
        return $this;
    }

    public function paymentSource(): PaymentSource
    {
        $this->payment_source = new PaymentSource();
        return $this->payment_source;
    }

    /**
     * @throws PaymentException
     * @throws GuzzleException|ValidationException
     * @throws OrderCreationException
     */
    public function create(): array
    {
        $this->setUrl();
        $token = $this->auth->getAccessToken();
        $response = $this->http
            ->withBearerToken($token)
            ->withHeaders([
                'User-Agent' => $this->configuration->getSdkVersion(),
                'PayPal-Request-Id' => $this->paypal_request_id ?? $this->getPaypalRequestId(),
                'return' => $this->getReturnType()
            ])->withJson([
                'intent' => $this->getIntent(),
                'purchase_units' => $this->getPurchaseUnits(),
                'payment_source' => $this->getPaymentSource(),
            ])->post($this->getUrl());
        $response['body']['success'] = $response['successfully'] ?? false;
        return $this->getResponse($response['body']);
    }

    /**
     * @throws OrderCreationException
     */
    private function getResponse(array $response): array
    {
        $links = array();
        if (!isset($response['links'])) {
            throw new OrderCreationException('Empty response');
        }
        foreach ($response['links'] as $link) {
            $links[str_replace('-', '_', $link['rel'])] = [
                'url' => $link['href'],
                'method' => $link['method']
            ];
        }
        if (empty($response['payment_source']['paypal'])) {
            unset($response['payment_source']['paypal']);
        }
        if (empty($response['payment_source'])) {
            unset($response['payment_source']);
        }
        $response['links'] = $links;
        $this->response = $response;
        return $this->response;
    }
}