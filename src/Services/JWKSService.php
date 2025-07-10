<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * JSON Web Key Set (JWKS) service
 */
class JWKSService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get JWKS
     */
    public function getJWKS(): array
    {
        return $this->client->request('GET', '/keys');
    }
} 