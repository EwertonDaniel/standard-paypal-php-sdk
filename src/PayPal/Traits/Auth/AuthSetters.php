<?php

namespace EwertonDaniel\PayPal\Traits\Auth;

use EwertonDaniel\PayPal\Exceptions\PayPalAuthenticationException;

trait AuthSetters
{
    protected array $scopes = array();
    protected string $access_token;
    protected string $token_type;
    protected string $app_id;
    protected int $expires_in;
    protected string $nonce;

    /**
     * @throws PayPalAuthenticationException
     */
    protected function setResponseParams(): void
    {
        if (!isset($this->response['access_token'])) throw new PayPalAuthenticationException('Authorization fail!', 401);
        $this->setScopes();
        $this->setAccessToken();
        $this->setTokenType();
        $this->setAppId();
        $this->setExpiresIn();
        $this->setNonce();
    }

    protected function setScopes(): void
    {
        if (isset($this->response['scope'])) {
            $this->scopes = explode(' ', $this->response['scope']);
        }
    }

    protected function setAccessToken(): void
    {
        if (isset($this->response['access_token'])) {
            $this->access_token = $this->response['access_token'];
        }
    }

    protected function setTokenType(): void
    {
        if (isset($this->response['token_type'])) {
            $this->token_type = $this->response['token_type'];
        }
    }

    protected function setAppId(): void
    {
        if (isset($this->response['app_id'])) {
            $this->app_id = $this->response['app_id'];
        }
    }

    protected function setExpiresIn(): void
    {
        if (isset($this->response['expires_id'])) {
            $this->expires_in = $this->response['expires_in'];
        }
    }

    protected function setNonce(): void
    {
        if (isset($this->response['nonce'])) {
            $this->nonce = $this->response['nonce'];
        }
    }
}