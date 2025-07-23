<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;
use Exception;

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

    public function getAuthorizationUrl(string $redirectUri, string $scope = 'openid%20profile%20email%20offline_access'): string
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->client->getClientId(),
            'redirect_uri' => $redirectUri,
            'scope' => $scope
        ]);
        return $this->client->getBaseUrl() . '/oauth/authorize?' . $query;
    }

    public function decodeJwt(string $jwtToken): array
    {
        // Split the JWT by dots
        $parts = explode('.', $jwtToken);
        if (count($parts) !== 3) {
            throw new Exception('Invalid JWT token provided');
        }

        // JWT parts: header, payload, signature
        list($header, $payload, $signature) = $parts;

        // Decode the payload (base64url)
        $payloadJson = $this->base64UrlDecode($payload);
        $payloadArray = json_decode($payloadJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON in payload');
        }

        return $payloadArray;
    }

    public function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        $data = strtr($data, '-_', '+/');
        return base64_decode($data);
    }
}