<?php

namespace EwertonDaniel\PayPal;

use Echosistema\SHR\Http;
use EwertonDaniel\PayPal\Configuration\Configuration;
use EwertonDaniel\PayPal\Exceptions\PayPalAuthenticationException;
use EwertonDaniel\PayPal\Traits\Auth\AuthGetters;
use EwertonDaniel\PayPal\Traits\Auth\AuthSetters;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;

class Auth
{
    use AuthSetters, AuthGetters;

    protected Configuration $configuration;
    protected string $url;
    protected mixed $response;
    protected string $user_agent;


    /**
     * @throws GuzzleException
     * @throws PayPalAuthenticationException
     */
    public function __construct(
        private readonly string $client_id,
        private readonly string $client_secret,
        public readonly bool    $is_production = false
    )
    {
        $this->__init__();
    }


    /**
     * @throws GuzzleException
     * @throws PayPalAuthenticationException
     * @throws Exception
     */
    private function __init__(): void
    {
        $this->configuration = new Configuration($this->is_production);
        $this->_setUrl();
        $this->_setUserAgent();
        $this->_authorize();
    }


    /**
     * @throws PayPalAuthenticationException
     */
    private function _setUrl(): void
    {
        $endpoint = $this->configuration->getEndpoint('auth');
        if (!isset($endpoint['uri'])) throw new PayPalAuthenticationException('URI error, endpoint not found!');
        $this->url = $this->configuration->getUrl() . $endpoint['uri'];
    }


    private function _setUserAgent(): void
    {
        $this->user_agent = $this->configuration->getSdkVersion();
    }

    /**
     * @throws GuzzleException
     * @throws PayPalAuthenticationException
     */
    private function _authorize(): void
    {
        $http = new Http();
        $reponse = $http->withBasicAuth($this->client_id, $this->client_secret)
            ->withHeaders(
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'User-Agent' => $this->user_agent
                ])
            ->withParams(['grant_type' => 'client_credentials'])
            ->post($this->url);
        $this->response = $reponse['body'];
        $this->setResponseParams();
    }

    public function toArray(): array
    {
        return [
            'scopes' => $this->getScopes(),
            'access_token' => $this->getAccessToken(),
            'token_type' => $this->getTokenType(),
            'app_id' => $this->getAppId(),
            'expires_in' => $this->getExpiresIn(),
            'nonce' => $this->getNonce()
        ];
    }

    public function __toString(): string
    {
        return Utils::jsonEncode($this->toArray());
    }
}