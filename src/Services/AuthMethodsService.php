<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Authentication methods service
 */
class AuthMethodsService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send passwordless authentication
     */
    public function sendPasswordless(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless:send", [
            'json' => $data
        ]);
    }

    /**
     * Verify passwordless authentication
     */
    public function verifyPasswordless(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless:verify", [
            'json' => $data
        ]);
    }

    /**
     * Resend passwordless authentication
     */
    public function resendPasswordless(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless:resend", [
            'json' => $data
        ]);
    }

    /**
     * Create passwordless connection
     */
    public function createPasswordlessConnection(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections", [
            'json' => $data
        ]);
    }

    /**
     * Update passwordless connection
     */
    public function updatePasswordlessConnection(string $organizationId, string $connectionId, array $data): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections/{$connectionId}", [
            'json' => $data
        ]);
    }

    /**
     * Enable passwordless connection
     */
    public function enablePasswordlessConnection(string $organizationId, string $connectionId): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections/{$connectionId}:enable");
    }

    /**
     * Send passwordless email (global)
     */
    public function sendPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/send', [
            'json' => $data
        ]);
    }

    /**
     * Verify passwordless email (global)
     */
    public function verifyPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/verify', [
            'json' => $data
        ]);
    }

    /**
     * Resend passwordless email (global)
     */
    public function resendPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/resend', [
            'json' => $data
        ]);
    }
} 