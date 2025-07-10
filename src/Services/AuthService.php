<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Authentication service for Scalekit
 */
class AuthService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get access token using client credentials
     */
    public function getAccessToken(): array
    {
        $response = $this->client->getHttpClient()->post('/oauth/token', [
            'form_params' => [
                'client_id' => $this->client->getClientId(),
                'client_secret' => $this->client->getClientSecret(),
                'grant_type' => 'client_credentials'
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        if (isset($data['access_token'])) {
            $this->client->setAccessToken($data['access_token']);
        }

        return $data;
    }

    /**
     * Exchange authorization code for access token
     */
    public function exchangeCodeForToken(string $code, string $redirectUri): array
    {
        $response = $this->client->getHttpClient()->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->client->getClientId(),
                'client_secret' => $this->client->getClientSecret(),
                'code' => $code,
                'redirect_uri' => $redirectUri
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Refresh access token
     */
    public function refreshToken(string $refreshToken): array
    {
        $response = $this->client->getHttpClient()->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => $this->client->getClientId(),
                'client_secret' => $this->client->getClientSecret(),
                'refresh_token' => $refreshToken
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        if (isset($data['access_token'])) {
            $this->client->setAccessToken($data['access_token']);
        }

        return $data;
    }

    /**
     * Revoke access token
     */
    public function revokeToken(string $token): array
    {
        $response = $this->client->getHttpClient()->post('/revoke', [
            'form_params' => [
                'client_id' => $this->client->getClientId(),
                'client_secret' => $this->client->getClientSecret(),
                'token' => $token
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Introspect token
     */
    public function introspectToken(string $token): array
    {
        $response = $this->client->getHttpClient()->post('/oauth/introspect', [
            'form_params' => [
                'client_id' => $this->client->getClientId(),
                'client_secret' => $this->client->getClientSecret(),
                'token' => $token
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get user info
     */
    public function getUserInfo(): array
    {
        return $this->client->request('GET', '/userinfo');
    }
} 