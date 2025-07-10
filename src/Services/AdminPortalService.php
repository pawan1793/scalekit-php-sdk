<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Admin Portal service
 */
class AdminPortalService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Generate portal link
     */
    public function generatePortalLink(string $organizationId, array $data = []): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/portal:generateLink", [
            'json' => $data
        ]);
    }

    /**
     * PUT portal links (raw endpoint)
     */
    public function putPortalLinks(string $organizationId, array $data = []): array
    {
        return $this->client->request('PUT', "/api/v1/organizations/{$organizationId}/portal_links", [
            'json' => $data
        ]);
    }
} 