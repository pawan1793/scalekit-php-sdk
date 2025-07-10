<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Connection management service
 */
class ConnectionService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * List connections
     */
    public function listConnections(string $organizationId, array $params = []): array
    {
        $query = http_build_query($params);
        $uri = "/api/v1/organizations/{$organizationId}/connections";
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Get connection
     */
    public function getConnection(string $organizationId, string $connectionId): array
    {
        return $this->client->request('GET', "/api/v1/organizations/{$organizationId}/connections/{$connectionId}");
    }

    /**
     * Enable connection
     */
    public function enableConnection(string $organizationId, string $connectionId): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/connections/{$connectionId}:enable");
    }

    /**
     * Get connection providers
     */
    public function getConnectionProviders(): array
    {
        return $this->client->request('GET', '/api/v1/connections/providers');
    }

    /**
     * Disable connection
     */
    public function disableConnection(string $organizationId, string $connectionId): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}/connections/{$connectionId}:disable");
    }

    /**
     * Update connection (PATCH /api/v1/connections/{connectionId})
     */
    public function updateConnection(string $connectionId, array $data): array
    {
        return $this->client->request('PATCH', "/api/v1/connections/{$connectionId}", [
            'json' => $data
        ]);
    }

    /**
     * Enable passwordless connection (PATCH /api/v1/connections/{connectionId}:enable)
     */
    public function enablePasswordlessConnection(string $connectionId): array
    {
        return $this->client->request('PATCH', "/api/v1/connections/{$connectionId}:enable");
    }

    /**
     * Get providers (GET /api/v1/providers)
     */
    public function getProviders(): array
    {
        return $this->client->request('GET', '/api/v1/providers');
    }
} 