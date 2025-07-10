<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Single Sign-On service
 */
class SSOService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Generate authorization URL
     */
    public function getAuthorizationUrl(array $params): string
    {
        $defaultParams = [
            'client_id' => $this->client->getClientId(),
            'response_type' => 'code',
            'scope' => 'openid email profile'
        ];

        $queryParams = array_merge($defaultParams, $params);
        
        return $this->client->getBaseUrl() . '/oauth/authorize?' . http_build_query($queryParams);
    }

    /**
     * Exchange authorization code for token
     */
    public function exchangeCodeForToken(string $code, string $redirectUri): array
    {
        return $this->client->auth->exchangeCodeForToken($code, $redirectUri);
    }
} 