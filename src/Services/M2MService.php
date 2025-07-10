<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Machine-to-Machine (M2M) service
 */
class M2MService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create M2M client
     */
    public function createM2MClient(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/clients", [
            'json' => $data
        ]);
    }

    /**
     * Create M2M client secret
     */
    public function createM2MClientSecret(string $organizationId, string $clientId): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/clients/{$clientId}/secrets");
    }

    /**
     * Get M2M client
     */
    public function getM2MClient(string $organizationId, string $clientId): array
    {
        return $this->client->request('GET', "/api/v1/organizations/{$organizationId}/clients/{$clientId}");
    }

    /**
     * Rotate M2M client secret
     */
    public function rotateSecret(string $organizationId, string $clientId): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/clients/{$clientId}:rotateSecret");
    }

    /**
     * Update M2M client details
     */
    public function updateM2MClient(string $organizationId, string $clientId, array $data): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}/clients/{$clientId}", [
            'json' => $data
        ]);
    }

    /**
     * Get M2M client access token
     */
    public function getM2MClientAccessToken(string $clientId, string $clientSecret): array
    {
        $response = $this->client->getHttpClient()->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete M2M client secret
     */
    public function deleteM2MClientSecret(string $organizationId, string $clientId, string $secretId): array
    {
        return $this->client->request('DELETE', "/api/v1/organizations/{$organizationId}/clients/{$clientId}/secrets/{$secretId}");
    }

    /**
     * Delete M2M client
     */
    public function deleteM2MClient(string $organizationId, string $clientId): array
    {
        return $this->client->request('DELETE', "/api/v1/organizations/{$organizationId}/clients/{$clientId}");
    }
} 