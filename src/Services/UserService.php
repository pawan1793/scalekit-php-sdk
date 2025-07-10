<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * User management service
 */
class UserService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * List users in organization
     */
    public function listUsers(string $organizationId, array $params = []): array
    {
        $query = http_build_query($params);
        $uri = "/api/v1/organizations/{$organizationId}/users";
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Create user
     */
    public function createUser(string $organizationId, array $userData): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/users", [
            'json' => $userData
        ]);
    }

    /**
     * List all users across organizations
     */
    public function listAllUsers(array $params = []): array
    {
        $query = http_build_query($params);
        $uri = '/api/v1/organizations/-/users';
        if ($query) {
            $uri .= '?' . $query;
        }
        return $this->client->request('GET', $uri);
    }
} 