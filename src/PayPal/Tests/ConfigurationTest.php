<?php

namespace EwertonDaniel\PayPal\Tests;

use EwertonDaniel\PayPal\Configuration\Configuration;
use EwertonDaniel\PayPal\Traits\DisplayColor;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    use DisplayColor;

    protected Configuration $configuration;

    function setUp(): void
    {
        $this->configuration = new Configuration();
    }

    function testIfSdkVersionInitiated(): void
    {
        $attribute = $this->configuration->getSdkVersion();
        if ($attribute) {
            print $this->information($attribute, true);
        }
        $this->assertNotNull($attribute);
    }

    function testIfUrlInitiated(): void
    {
        $attribute = $this->configuration->getUrl();
        if ($attribute) {
            print $this->success("URL OK");
            print $this->information($attribute, true);
        }
        $this->assertNotNull($attribute);
    }

    function testIfEndpointsInitiated(): void
    {
        $attribute = $this->configuration->getEndpoints();
        if (!empty($attribute)) {
            print $this->success("ENDPOINTS OK");
            print $this->information(json_encode($attribute), true);
        }
        $this->assertIsArray($attribute);
    }

    function testIfEndpointInitiated(): void
    {
        $attribute = $this->configuration->getEndpoint('test');
        if (!empty($attribute)) {
            print $this->success("ENDPOINT OK");
            print $this->information(json_encode($attribute), true);
        }
        $this->assertIsArray($attribute);
    }
}