<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Organization management service
 */
class OrganizationService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * List organizations
     */
    public function listOrganizations(array $params = []): array
    {
        $query = http_build_query($params);
        $uri = '/api/v1/organizations';
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Search organizations
     */
    public function searchOrganizations(array $params = []): array
    {
        $query = http_build_query($params);
        $uri = '/api/v1/organizations:search';
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Create organization
     */
    public function createOrganization(array $data): array
    {
        return $this->client->request('POST', '/api/v1/organizations', [
            'json' => $data
        ]);
    }

    /**
     * Get organization by ID
     */
    public function getOrganization(string $organizationId): array
    {
        return $this->client->request('GET', "/api/v1/organizations/{$organizationId}");
    }

    /**
     * Get organization by external ID
     */
    public function getOrganizationByExternalId(string $externalId): array
    {
        return $this->client->request('GET', "/api/v1/organizations:lookupExternalId?external_id={$externalId}");
    }

    /**
     * Update organization
     */
    public function updateOrganization(string $organizationId, array $data): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}", [
            'json' => $data
        ]);
    }

    /**
     * Update organization settings
     */
    public function updateOrganizationSettings(string $organizationId, array $settings): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}/settings", [
            'json' => $settings
        ]);
    }

    /**
     * Delete organization
     */
    public function deleteOrganization(string $organizationId): array
    {
        return $this->client->request('DELETE', "/api/v1/organizations/{$organizationId}");
    }
} 