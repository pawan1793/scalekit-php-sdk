<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Directory management service
 */
class DirectoryService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all directories
     */
    public function listDirectories(array $params = []): array
    {
        $query = http_build_query($params);
        $uri = '/api/v1/directories';
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Get directory
     */
    public function getDirectory(string $directoryId): array
    {
        return $this->client->request('GET', "/api/v1/directories/{$directoryId}");
    }

    /**
     * List users in directory
     */
    public function listUsersInDirectory(string $directoryId, array $params = []): array
    {
        $query = http_build_query($params);
        $uri = "/api/v1/directories/{$directoryId}/users";
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * List groups in directory
     */
    public function listGroupsInDirectory(string $directoryId, array $params = []): array
    {
        $query = http_build_query($params);
        $uri = "/api/v1/directories/{$directoryId}/groups";
        
        if ($query) {
            $uri .= '?' . $query;
        }

        return $this->client->request('GET', $uri);
    }

    /**
     * Enable directory
     */
    public function enableDirectory(string $directoryId): array
    {
        return $this->client->request('POST', "/api/v1/directories/{$directoryId}:enable");
    }

    /**
     * Disable directory
     */
    public function disableDirectory(string $directoryId): array
    {
        return $this->client->request('POST', "/api/v1/directories/{$directoryId}:disable");
    }
} 