<?php

namespace EwertonDaniel\PayPal\Configuration;

use Exception;

class Configuration
{
    protected string $url;
    protected array $endpoints;
    protected mixed $configuration;
    protected string $sdk_version;
    private string $configurationFile = __DIR__ . '/configuration.json';

    /**
     * @throws Exception
     */
    public function __construct(private bool $is_production = false)
    {
        $this->__init__();
    }

    /**
     * @throws Exception
     */
    private function __init__(): void
    {
        $this->setConfigurations();
        $this->setSdkVersion();
        $this->setUrl();
        $this->setEndpoints();
    }

    public function setIsProduction(bool $is_production = false): static
    {
        $this->is_production = $is_production;
        return $this;
    }

    private function setSdkVersion(): void
    {
        $api = $this->configuration('API');
        if (!isset($api['name']) || !isset($api['version'])) {
            $this->sdk_version = "PayPal Standard PHP SDK *";
        } else {
            $this->sdk_version = $api['name'] . '/' . $api['version'];
        }
    }

    /**
     * @throws Exception
     */
    private function setConfigurations(): void
    {
        $file = file_get_contents($this->configurationFile);
        $configuration = json_decode($file, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error in load configuration.json file");
        }
        $this->configuration = $configuration;
    }

    private function setUrl(): void
    {
        $param = !$this->is_production ? 'ROOT_SANDBOX_URL' : 'ROOT_LIVE_URL';
        $this->url = $this->configuration($param);
    }

    private function setEndpoints(): void
    {
        $this->endpoints = $this->configuration('ENDPOINTS');
    }

    private function configuration($parameter)
    {
        if (!str_contains($parameter, '.')) {
            $parameter = strtoupper($parameter);
            if (!isset($this->configuration[$parameter])) {
                return null;
            }
            return $this->configuration[$parameter];
        } else {
            $param = explode('.', $parameter);
            $param[0] = strtoupper($param[0]);
            if (!isset($this->configuration[$param[0]][$param[1]])) {
                return null;
            }
            return $this->configuration[$param[0]][$param[1]];
        }
    }

    /**
     * @return string
     */
    public function getSdkVersion(): string
    {
        return $this->sdk_version;
    }

    /**
     * @return string|null
     */
    public function getUrl(): string|null
    {
        return $this->url ?? null;
    }

    /**
     * @return array
     */
    public function getEndpoints(): array
    {
        return $this->endpoints ?? [];
    }

    /**
     * @param $endpoint
     * @return array|null
     */
    public function getEndpoint($endpoint): null|array
    {
        $endpoint = $this->endpoints[$endpoint] ?? null;
        if (!isset($endpoint['uri']) || !isset($endpoint['method'])) return null;
        $endpoint['method'] = strtoupper($endpoint['method']);
        return $endpoint;
    }
}