<?php

namespace EwertonDaniel\PayPal\Traits\Auth;

trait AuthGetters
{
    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes ?? [];
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): string|null
    {
        return $this->access_token ?? null;
    }

    /**
     * @return string|null
     */
    public function getTokenType(): string|null
    {
        return $this->token_type ?? null;
    }

    /**
     * @return string|null
     */
    public function getAppId(): string|null
    {
        return $this->app_id ?? null;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in ?? 0;
    }

    /**
     * @return string|null
     */
    public function getNonce(): string|null
    {
        return $this->nonce ?? null;
    }
}