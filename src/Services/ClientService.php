<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Client configuration service
 */
class ClientService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get client by ID
     */
    public function getClient(string $clientId): array
    {
        return $this->client->request('GET', "/api/v1/clients/{$clientId}");
    }

    /**
     * Update client redirects
     */
    public function updateClientRedirects(string $clientId, array $redirects): array
    {
        return $this->client->request('PATCH', "/api/v1/clients/{$clientId}", [
            'json' => [
                'redirect_uris' => $redirects
            ]
        ]);
    }
} 