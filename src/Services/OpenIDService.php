<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * OpenID Connect service
 */
class OpenIDService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get OpenID configuration
     */
    public function getConfiguration(): array
    {
        return $this->client->request('GET', '/.well-known/openid-configuration');
    }
} 